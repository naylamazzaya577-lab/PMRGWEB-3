<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (($_SESSION['mode'] ?? '') !== 'guest') {
    header('Location: ../index.php');
    exit;
}
require __DIR__ . '/../includes/koneksi.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../checkout.php');
    exit;
}
csrf_verify();
$nama = trim($_POST['nama'] ?? '');
$nohp = preg_replace('/[\s-]+/', '', trim($_POST['no_hp'] ?? ''));
$memberCode = trim($_POST['kode_member'] ?? '');
if ($memberCode === '-') $memberCode = '';
$service = $_POST['layanan'] ?? '';
$address = trim($_POST['alamat'] ?? '');
$distance = filter_var($_POST['jarak_km'] ?? '0', FILTER_VALIDATE_FLOAT);
$payment = $_POST['metode_bayar'] ?? '';
$rawItems = json_decode($_POST['items_json'] ?? '', true);
$errors = [];
if ($nama === '' || strlen($nama) > 150) $errors[] = 'Nama wajib diisi.';
if (!preg_match('/^\+?[0-9]{8,15}$/', $nohp)) $errors[] = 'Nomor HP tidak valid.';
if (!in_array($service, ['pickup', 'delivery'], true)) $errors[] = 'Metode penerimaan tidak valid.';
if ($service === 'delivery' && ($address === '' || strlen($address) > 1000)) $errors[] = 'Alamat pengantaran wajib diisi.';
if ($distance === false || $distance < 0 || $distance > 200 || ($service === 'delivery' && $distance < 0.1)) $errors[] = 'Jarak pengantaran tidak valid.';
if (!in_array($payment, ['QRIS', 'Transfer', 'Cash'], true)) $errors[] = 'Metode pembayaran tidak valid.';
if (strlen($memberCode) > 30) $errors[] = 'Kode member terlalu panjang.';
if (!is_array($rawItems) || count($rawItems) < 1 || count($rawItems) > 100) $errors[] = 'Keranjang kosong atau tidak valid.';
if ($errors) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: ../checkout.php');
    exit;
}

try {
    $pdo->beginTransaction();
    $orderItems = [];
    $subtotal = 0.0;
    $findProduct = $pdo->prepare('SELECT id, nama_produk, harga, stok FROM produk WHERE id = :id FOR UPDATE');
    foreach ($rawItems as $item) {
        if (!is_array($item)) throw new RuntimeException('Salah satu produk pada keranjang tidak valid.');
        $id = filter_var($item['id'] ?? null, FILTER_VALIDATE_INT);
        $quantity = filter_var($item['quantity'] ?? null, FILTER_VALIDATE_INT);
        if (!$id || !$quantity || $quantity < 1 || $quantity > 50) {
            throw new RuntimeException('Salah satu produk pada keranjang tidak valid.');
        }
        $findProduct->execute([':id' => $id]);
        $product = $findProduct->fetch();
        if (!$product || (int) $product['stok'] < $quantity) {
            throw new RuntimeException('Produk ' . ($product['nama_produk'] ?? '') . ' tidak tersedia sebanyak jumlah yang diminta.');
        }
        $price = (float) $product['harga'];
        $subtotal += $price * $quantity;
        $orderItems[] = ['id' => (int) $product['id'], 'name' => $product['nama_produk'], 'quantity' => $quantity, 'price' => $price];
        $pdo->prepare('UPDATE produk SET stok = stok - :quantity WHERE id = :id')->execute([':quantity' => $quantity, ':id' => $id]);
    }

$validPromoCodes = ['140706', '170806'];
$discount = 0.0;
if ($memberCode !== '') {
    if (!in_array($memberCode, $validPromoCodes, true)) {
        throw new RuntimeException('Kode promo tidak valid. Kosongkan jika tidak punya kode.');
    }
    $discount = round($subtotal * 0.04, 2);
}
    $shipping = $service === 'delivery' && $distance > 7.5 ? ceil($distance - 7.5) * 5000 : 0;
    $total = $subtotal - $discount + $shipping;
    $code = 'TB-' . date('ymd') . '-' . strtoupper(bin2hex(random_bytes(3)));
    $insert = $pdo->prepare('INSERT INTO pesanan (kode_pesanan, nama_pelanggan, no_hp, kode_member, metode_layanan, alamat, jarak_km, subtotal, diskon, ongkir, total, metode_bayar, detail_produk)
        VALUES (:kode, :nama, :nohp, :member, :layanan, :alamat, :jarak, :subtotal, :diskon, :ongkir, :total, :bayar, CAST(:detail AS JSONB))');
    $insert->execute([
        ':kode' => $code, ':nama' => $nama, ':nohp' => $nohp, ':member' => $memberCode !== '' ? $memberCode : null,
        ':layanan' => $service, ':alamat' => $service === 'delivery' ? $address : null, ':jarak' => $service === 'delivery' ? $distance : 0,
        ':subtotal' => $subtotal, ':diskon' => $discount, ':ongkir' => $shipping, ':total' => $total, ':bayar' => $payment,
        ':detail' => json_encode($orderItems, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE),
    ]);
    $pdo->commit();
} catch (Throwable $error) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    if ($error instanceof PDOException) {
        error_log('Gagal menyimpan pesanan Taslimiyah: ' . $error->getMessage());
    }
    error_log('DETAIL: ' . get_class($error) . ' | ' . $error->getMessage());

    // Hanya pesan buatan sendiri (RuntimeException) yang boleh tampil ke pengguna
    $pesanUser = $error instanceof RuntimeException
        ? $error->getMessage()
        : 'Pesanan gagal diproses. Silakan coba lagi.';
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => $pesanUser];
    header('Location: ../checkout.php');
    exit;
}
$_SESSION['last_order_code'] = $code;
header('Location: ../nota.php?kode=' . rawurlencode($code));
exit;

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Jasa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 150%;
            max-width: 1000px;
            margin: 20px auto;
            display: flex;
            gap: 20px;
        }

        .left-section, .right-section {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .left-section {
            flex: 3;
        }

        .right-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .service-image {
            width: 100%;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .description {
            margin-top: 20px;
        }

        .description h2 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }

        .description p {
            margin: 10px 0;
            color: #555;
            line-height: 1.6;
        }

        .package-details {
            background-color: #f5f5f5;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .package-details h4 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }

        .price {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            margin: 10px 0;
        }

        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .action-buttons button {
            padding: 10px;
            font-size: 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .buy-button {
            background-color: #28a745;
            color: #fff;
        }

        .inquire-button {
            background-color: #007bff;
            color: #fff;
        }

        .secure-transaction {
            margin-top: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            text-align: center;
        }

        .secure-transaction img {
            width: 40px;
            margin-bottom: 10px;
        }

        .secure-transaction p {
            color: #555;
            margin: 0;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Left Section: Image and Description -->
    <div class="left-section">
        <!-- Image -->
        <img src="<?= base_url('images/img/' . $item->gambar) ?>" class="service-image" alt="Gambar">

        <!-- Description -->
        <div class="description">
            <h2><?= $item->nama ?></h2>

            <p>
                Halo, saya Riski. Saya akan membantu Anda untuk mewujudkan logo impian untuk bisnis Anda. 
                Saya sudah berpengalaman mengerjakan berbagai macam logo untuk berbagai perusahaan.
            </p>
            <p>
                Saya menyediakan berbagai pilihan paket untuk memenuhi kebutuhan Anda dengan hasil terbaik dalam waktu yang singkat.
            </p>
        </div>
    </div>

    <!-- Right Section: Pricing and Actions -->
    <div class="right-section">
        <!-- Package Details -->
        <div class="package-details">
            <h4>Basic</h4>
            <div class="price">Rp <?= number_format($item->harga, 0, ',', '.') ?></div>
            <p>Paket ini mencakup 3 pilihan logo dengan durasi pengerjaan 1 hari.</p>
            <p>File yang dikirim: JPG, PNG, PDF (HiRes).</p>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <button class="buy-button">Beli Paket Basic</button>
            <button class="inquire-button">Tanya Dulu</button>
        </div>

        <!-- Secure Transaction -->
        <div class="secure-transaction">
            <img src="secure_icon.png" alt="Secure">
            <p>Transaksi dijamin aman dan garansi uang kembali.</p>
        </div>
    </div>
</div>

</body>
</html>

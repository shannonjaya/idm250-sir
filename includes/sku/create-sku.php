<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") { 
        $ficha = $_POST['ficha'] ?? "";
        $sku = $_POST['sku'] ?? "";
        $description = $_POST['description'] ?? "";
        $uom = $_POST['uom'] ?? "";
        $pieces = $_POST['pieces'] ?? 0;
        $length = $_POST['length'] ?? 0.0;
        $width = $_POST['width'] ?? 0.0;
        $height = $_POST['height'] ?? 0.0;
        $weight = $_POST['weight'] ?? 0.0;
        $assembly = (int) $_POST['assembly'];
        $rate = $_POST['rate'] ?? 0.0;

    $stmt = $connection->prepare("INSERT INTO idm250_sku (ficha, sku, description, uom_primary, piece_count, length_inches, width_inches, height_inches, weight_lbs, assembly, rate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssiidddsi", $ficha, $sku, $description, $uom, $pieces, $length, $width, $height, $weight, $assembly, $rate);
    $stmt->execute();
    $stmt->close();

    header("Location: ../idm250-sir/index.php?view=sku");
    exit;
    }
?>

<header class="main-header">
    <h1 class="main-heading">Create SKU</h1>
</header>

<form method="post">
    <div class="row">
        <div class="form-item">
            <label for="ficha">Ficha</label>
            <input type="number" min="0" id="ficha" name="ficha" placeholder="000" required>
        </div>
        <div class="form-item">
            <label for="sku">SKU</label>
            <input type="text" min="0" id="sku" name="sku" placeholder="0000000-0000" required>
        </div>
    </div>
        
    <div class="row">
        <div class="form-item">
            <label for="description">Description</label>
            <textarea id="description" maxlength="100" name="description" placeholder="Description" required></textarea>
        </div>
    </div>

    <div class="row">
        <div class="form-item">
            <label for="uom">UOM</label>
            <input type="text" id="uom" name="uom" placeholder="Unit of Measure" required>
        </div>
        <div class="form-item">
            <label for="pieces">Pieces</label>
            <input type="number" min="0" id="pieces" name="pieces" placeholder="0" required>
        </div>
    </div>

    <div class="row">
        <div class="form-item">
            <label for="length">Length (inches)</label>
        <input type="number" min="0" step="0.01" id="length" name="length" placeholder="0.00" required>
        </div>
        <div class="form-item">
            <label for="width">Width (inches)</label>
            <input type="number" min="0" step="0.01" id="width" name="width" placeholder="0.00" required>
        </div>
        <div class="form-item">
            <label for="height">Height (inches)</label>
            <input type="number" min="0" step="0.01" id="height" name="height" placeholder="0.00" required>
        </div>
        <div class="form-item">
            <label for="weight">Weight (lbs)</label>
            <input type="number" min="0" step="0.01" id="weight" name="weight" placeholder="0.00" required>
        </div>
    </div>

    <div class="row">
        <div class="form-item">
            <label for="assembly">Assembly</label>
            <select id="assembly" name="assembly" required>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </div>
        <div class="form-item">
            <label for="rate">Rate</label>
            <input type="number" min="0" step="0.01" id="rate" name="rate" placeholder="0.00"required>
        </div>
    </div>

    <div class="btn-wrapper"><button type="submit" class="primary-btn">Create SKU</button></div>
</form>
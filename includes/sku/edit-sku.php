<?php
    $id = "";
    $ficha = "";
    $sku = "";
    $description = "";
    $uom = "";
    $pieces = "";
    $length = "";
    $width = "";
    $height = "";
    $weight = "";
    $assembly = "";
    $rate = "";

    if ($_SERVER["REQUEST_METHOD"] == "GET"){ 
        if(!isset($_GET['id'])) {
            header("Location: ../idm250-sir/index.php?view=sku");
            exit;
        }

        $id = $_GET['id'];

        $stmt = $connection->prepare("SELECT * FROM idm250_sku WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        if (!$row) {
            header("Location: ../idm250-sir/index.php?view=sku");
            exit;
        }

        $ficha = $row['ficha'];
        $sku = $row['sku'];
        $description = $row['description'];
        $uom = $row['uom_primary'];
        $pieces = $row['piece_count'];
        $length = $row['length_inches'];
        $width = $row['width_inches'];
        $height = $row['height_inches'];
        $weight = $row['weight_lbs'];
        $assembly = $row['assembly'];
        $rate = $row['rate'];
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST"){ 
        $id = $_POST['id'];
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

        $stmt = $connection->prepare("UPDATE idm250_sku SET ficha = ?, sku = ?, description = ?, uom_primary = ?, piece_count = ?, length_inches = ?, width_inches = ?, height_inches = ?, weight_lbs = ?, assembly = ?, rate = ? WHERE id = ?");
        $stmt->bind_param("ssssiddddidi", $ficha, $sku, $description, $uom, $pieces, $length, $width, $height, $weight, $assembly, $rate, $id);
        $stmt->execute();
        $stmt->close();

        header("Location: ../idm250-sir/index.php?view=sku");
        exit;
    }
?>


<header class="main-header">
        <h1 class="main-heading">Edit SKU</h1>
</header>

<form method="post">
    <input type="hidden" name="id" value="<?php echo $id; ?>">

    <fieldset class="row">
        <legend>SKU Details</legend>
        <div class="form-item">
            <label for="ficha">Ficha</label>
            <input type="number" min="0" id="ficha" name="ficha"  value="<?php echo $ficha; ?>" placeholder="000" required>
        </div>
        <div class="form-item">
            <label for="sku">SKU</label>
            <input type="text" min="0" id="sku" name="sku"  value="<?php echo $sku; ?>" placeholder="0000000-0000" required>
        </div>
    </fieldset>
            
    <fieldset class="row">
        <legend>Description</legend>
        <div class="form-item">
            <label for="description">Description</label>
            <textarea id="description" maxlength="100" name="description" placeholder="Description" required><?php echo $description; ?></textarea>
        </div>
    </fieldset>

    <fieldset class="row">
        <legend>Packaging</legend>
        <div class="form-item">
            <label for="uom">UOM</label>
            <select id="uom" name="uom" required>
                <option value="PALLET" <?php if ($uom === "PALLET") { echo 'selected'; } ?>>PALLET</option>
                <option value="BUNDLE" <?php if ($uom === "BUNDLE") { echo 'selected'; } ?>>BUNDLE</option>
            </select>
        </div>
        <div class="form-item">
            <label for="pieces">Pieces</label>
            <input type="number" min="0" id="pieces" name="pieces" value="<?php echo $pieces; ?>" placeholder="0" required>
        </div>
    </fieldset>

    <fieldset class="row">
        <legend>Dimensions</legend>
        <div class="form-item">
            <label for="length">Length (inches)</label>
            <input type="number" min="0" step="0.01" id="length" name="length" value="<?php echo $length; ?>" placeholder="0.00" required>
        </div>
        <div class="form-item">
            <label for="width">Width (inches)</label>
            <input type="number" min="0" step="0.01" id="width" name="width" value="<?php echo $width; ?>" placeholder="0.00" required>
        </div>
        <div class="form-item">
            <label for="height">Height (inches)</label>
            <input type="number" min="0" step="0.01" id="height" name="height" value="<?php echo $height; ?>" placeholder="0.00" required>
        </div>
        <div class="form-item">
            <label for="weight">Weight (lbs)</label>
            <input type="number" min="0" step="0.01" id="weight" name="weight" value="<?php echo $weight; ?>" placeholder="0.00" required>
        </div>
    </fieldset>

    <fieldset class="row">
        <legend>Assembly & Rate</legend>
        <div class="form-item">
            <label for="assembly">Assembly</label>
            <select id="assembly" name="assembly" required>
                <option value="1" <?php if ((int)$assembly === 1) echo 'selected'; ?>>Yes</option>
                <option value="0" <?php if ((int)$assembly === 0) echo 'selected'; ?>>No</option>
            </select>
        </div>
        <div class="form-item">
            <label for="rate">Rate</label>
            <input type="number" min="0" step="0.01" id="rate" name="rate" value="<?php echo $rate; ?>" placeholder="0.00" required>
        </div>
    </fieldset>

    <div class="btn-wrapper"><button type="submit" class="primary-btn">Edit SKU</button></div>
</form>

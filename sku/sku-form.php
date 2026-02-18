<?php require_once __DIR__ . '/../lib/functions.php'; // Create or Edit SKU

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$sku = $id ? get_sku($connection, $id) : [];

    if ($_SERVER['REQUEST_METHOD']=== 'POST'){
        $sku = $_POST['sku'] ?? "";
        $description = $_POST['description'] ?? "";
        $uom_primary = $_POST['uom_primary'] ?? "";
        $pieces = $_POST['pieces'] ?? 0;
        $length = $_POST['length'] ?? 0.0;
        $width = $_POST['width'] ?? 0.0;
        $height = $_POST['height'] ?? 0.0;
        $weight = $_POST['weight'] ?? 0.0;
    
        if ($id) {
            edit_sku($connection, $id, $sku, $description, $uom_primary, $pieces, $length, $width, $height, $weight);
        } else {
            $id = create_sku($connection, $sku, $description, $uom_primary, $pieces, $length, $width, $height, $weight);
        }
        header("Location: index.php?view=sku");
        exit;
    }
?>

<header class="main-header">
        <h1 class="main-heading"><?php echo isset($_GET['id']) ? 'Edit ' : 'Create '; ?>SKU</h1>
</header>

<form method="post">
    <input type="hidden" name="id" value="<?php echo $id; ?>">

    <fieldset class="row">
        <legend>SKU Details</legend>
        <div class="form-item">
            <label for="sku">SKU</label>
            <input type="text" min="0" id="sku" name="sku"  value="<?= ($sku['sku']) ?? ''; ?>" placeholder="0000000-0000" required>
        </div>
    </fieldset>
            
    <fieldset class="row">
        <legend>Description</legend>
        <div class="form-item">
            <label for="description">Description</label>
            <textarea id="description" maxlength="100" name="description" placeholder="Description" required><?= ($sku['description']) ?? ''; ?></textarea>
        </div>
    </fieldset>

    <fieldset class="row">
        <legend>Packaging</legend>
        <div class="form-item">
            <label for="uom_primary">UOM</label>
            <select id="uom_primary" name="uom_primary" required>
                <option value="PALLET" <?php if (($sku['uom_primary'] ?? '') === "PALLET") { echo 'selected'; } ?>>PALLET</option>
                <option value="BUNDLE" <?php if (($sku['uom_primary'] ?? '') === "BUNDLE") { echo 'selected'; } ?>>BUNDLE</option>
            </select>
        </div>
        <div class="form-item">
            <label for="pieces">Pieces</label>
            <input type="number" min="0" id="pieces" name="pieces" value="<?= ($sku['pieces']) ?? ''; ?>" placeholder="0" required>
        </div>
    </fieldset>

    <fieldset class="row">
        <legend>Dimensions</legend>
        <div class="form-item">
            <label for="length">Length (inches)</label>
            <input type="number" min="0" step="0.01" id="length" name="length" value="<?= ($sku['length_inches']) ?? ''; ?>" placeholder="0.00" required>
        </div>
        <div class="form-item">
            <label for="width">Width (inches)</label>
            <input type="number" min="0" step="0.01" id="width" name="width" value="<?= ($sku['width_inches']) ?? ''; ?>" placeholder="0.00" required>
        </div>
        <div class="form-item">
            <label for="height">Height (inches)</label>
            <input type="number" min="0" step="0.01" id="height" name="height" value="<?= ($sku['height_inches']) ?? ''; ?>" placeholder="0.00" required>
        </div>
        <div class="form-item">
            <label for="weight">Weight (lbs)</label>
            <input type="number" min="0" step="0.01" id="weight" name="weight" value="<?= ($sku['weight_lbs']) ?? ''; ?>" placeholder="0.00" required>
        </div>
    </fieldset>

    <div class="btn-wrapper"><button type="submit" class="primary-btn"><?php echo isset($_GET['id']) ? 'Edit ' : 'Create '; ?>SKU</button></div>
</form>



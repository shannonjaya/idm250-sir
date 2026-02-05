<?php
require_once './lib/sku.php';
$skus = get_all_skus($connection);
?>

<header class="main-header">
    <h1 class="main-heading">SKU Management</h1>
    <a href="?view=sku-form" class="primary-btn">Create SKU</a>
</header>

<table>
    <thead>
        <tr>
            <th>Ficha</th>
            <th>SKU</th>
            <th>Description</th>
            <th>UOM</th>
            <th>Pieces</th>
            <th><div class="tooltip">Dimensions<span class="tooltip-text">L x W x H, inches</span></div></th>
            <th><div class="tooltip">Weight<span class="tooltip-text">pounds</span></div></th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($skus as $sku): ?>
            <tr>
                <td><?=$sku['ficha']; ?></td>
                <td><?=$sku['sku']; ?></td>
                <td><?=$sku['description']; ?></td>
                <td>
                    <p class="highlight<?php if ($sku['uom'] === 'PALLET') { echo "-green"; } ?>">
                        <?=$sku['uom']; ?>
                    </p>
                </td>
                <td><?=$sku['pieces']; ?></td>
                <td><?=$sku['length_inches'] . " x " . $sku['width_inches'] . " x " . $sku['height_inches']; ?></td>
                <td><?=$sku['weight_lbs']; ?></td>
                <td class="col-actions">
                        <a href="?view=sku-form&id=<?php echo $sku['id']; ?>" class="icon-btn">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <mask id="mask0_20_27" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24"><rect width="24" height="24" fill="#D9D9D9"/></mask><g mask="url(#mask0_20_27)"><path d="M5.30775 20.5C4.80258 20.5 4.375 20.325 4.025 19.975C3.675 19.625 3.5 19.1974 3.5 18.6923V5.30777C3.5 4.80261 3.675 4.37502 4.025 4.02502C4.375 3.67502 4.80258 3.50002 5.30775 3.50002H13.9635L12.4635 5.00002H5.30775C5.23075 5.00002 5.16025 5.03211 5.09625 5.09627C5.03208 5.16027 5 5.23077 5 5.30777V18.6923C5 18.7693 5.03208 18.8398 5.09625 18.9038C5.16025 18.9679 5.23075 19 5.30775 19H18.6923C18.7693 19 18.8398 18.9679 18.9038 18.9038C18.9679 18.8398 19 18.7693 19 18.6923V11.473L20.5 9.97302V18.6923C20.5 19.1974 20.325 19.625 19.975 19.975C19.625 20.325 19.1974 20.5 18.6923 20.5H5.30775ZM9.5 14.5V11.0673L18.5598 2.00777C18.7148 1.85261 18.8852 1.73944 19.0712 1.66827C19.2571 1.59711 19.4462 1.56152 19.6385 1.56152C19.8347 1.56152 20.0231 1.59711 20.2038 1.66827C20.3846 1.73944 20.5493 1.84936 20.698 1.99802L21.9538 3.25002C22.0986 3.40519 22.2098 3.57636 22.2875 3.76352C22.365 3.95069 22.4038 4.14044 22.4038 4.33277C22.4038 4.52511 22.3708 4.71161 22.3048 4.89227C22.2388 5.07311 22.1282 5.24102 21.973 5.39602L12.8845 14.5H9.5ZM11 13H12.2463L18.4788 6.76727L17.8558 6.14427L17.1885 5.50202L11 11.6905V13Z"/></g>
                            </svg>
                        </a>
                        <form action="?view=delete-sku" method="post">
                            <input type="hidden" name="id" value="<?=$sku['id']; ?>">
                            <button class="icon-btn" type="submit" onclick="return confirm('Are you sure you want to delete SKU <?=$sku['sku']; ?>?');">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <mask id="mask0_20_33" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24"><rect width="24" height="24" fill="#D9D9D9"/></mask><g mask="url(#mask0_20_33)"><path d="M7.30775 20.5C6.80908 20.5 6.38308 20.3234 6.02975 19.9702C5.67658 19.6169 5.5 19.1909 5.5 18.6922V5.99998H4.5V4.49998H9V3.61548H15V4.49998H19.5V5.99998H18.5V18.6922C18.5 19.1974 18.325 19.625 17.975 19.975C17.625 20.325 17.1974 20.5 16.6923 20.5H7.30775ZM17 5.99998H7V18.6922C7 18.7821 7.02883 18.8558 7.0865 18.9135C7.14417 18.9711 7.21792 19 7.30775 19H16.6923C16.7693 19 16.8398 18.9679 16.9038 18.9037C16.9679 18.8397 17 18.7692 17 18.6922V5.99998ZM9.404 17H10.9037V7.99998H9.404V17ZM13.0962 17H14.596V7.99998H13.0962V17Z"/></g>
                                </svg>
                            </button>
                            </a>
                        </form>
                </td>
            </tr>
            <?php endforeach; ?>
    </tbody>
</table>

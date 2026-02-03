<?php
$activeView = $_GET['view'] ?? 'sku';
$userEmail = $_SESSION['user']['email'] ?? null;
?>

<aside class="sidebar">
  <nav class="sidebar-nav">

    <div class="sidebar-title">
      <svg
        class="sidebar-logo"
        width="64"
        height="34"
        viewBox="0 0 64 34"
        fill="currentColor"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path d="M9.8055 9.67529C11.6008 9.67529 13.1953 9.99626 14.5838 10.6421H14.5828C16.0035 11.2563 17.1678 12.1941 18.0721 13.4536L18.1512 13.5649L15.1659 16.5503L15.0535 16.4048C14.4352 15.601 13.6624 14.9834 12.7342 14.5503L12.7323 14.5493C11.8375 14.1174 10.8155 13.8989 9.66292 13.8989C8.44202 13.899 7.52689 14.1186 6.89827 14.5376L6.8973 14.5396C6.30925 14.9218 6.01946 15.4568 6.01937 16.1636C6.01937 16.8778 6.28341 17.4143 6.80843 17.7935C7.36043 18.1921 8.08752 18.5341 8.99495 18.8159H8.99593C9.94794 19.1015 10.9317 19.4029 11.9471 19.7202H11.9461C12.9716 20.0089 13.9492 20.4095 14.8787 20.9224C15.8192 21.4412 16.5826 22.1397 17.1678 23.0161C17.7949 23.9073 18.1024 25.0691 18.1024 26.4868C18.1024 28.655 17.3222 30.3826 15.7596 31.6528C14.2322 32.9202 12.1788 33.5463 9.61605 33.5464C8.33391 33.5464 7.11359 33.3853 5.95687 33.064L5.95198 33.063C4.82909 32.7101 3.78573 32.228 2.8221 31.6177L2.8182 31.6157C1.85409 30.9729 1.01751 30.2171 0.309406 29.3481L0.217609 29.2349L3.07894 26.3726L3.20589 26.2466L3.31917 26.3853C4.12882 27.3817 5.0597 28.1265 6.11214 28.6226H6.11312C7.16825 29.088 8.35062 29.3227 9.66292 29.3228C10.9778 29.3228 11.9733 29.1027 12.6668 28.6821C13.3535 28.2343 13.6882 27.634 13.6883 26.8677Z"/>
      </svg>

      <h2 class="sidebar-subheading">CA Manufacturing CMS</h2>

      <?php if ($userEmail): ?>
        <p
          style="
            margin-top: 0.5rem;
            font-size: var(--font-small);
            color: var(--light-gray);
          "
        >
          Logged in as<br>
          <strong><?= htmlspecialchars($userEmail) ?></strong>
        </p>
      <?php endif; ?>
    </div>

    <hr>

    <ul class="sidebar-menu">

      <li class="sidebar-item">
        <a
          href="?view=sku"
          class="sidebar-link<?= ($activeView === 'sku' || $activeView === 'create-sku' || $activeView === 'edit-sku') ? '-active' : '' ?>"
        >
          <svg class="sidebar-icon" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
            <path d="M1.25 20.75V16.25H2.75V19.25H5.75V20.75H1.25Z"/>
          </svg>
          SKU
        </a>
      </li>

      <li class="sidebar-item">
        <a
          href="?view=inventory"
          class="sidebar-link<?= ($activeView === 'inventory') ? '-active' : '' ?>"
        >
          <svg class="sidebar-icon" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
            <path d="M4.5 19.5V7.6H19.5V19.5Z"/>
          </svg>
          Inventory
        </a>
      </li>

      <li class="sidebar-item">
        <a
          href="?view=mpl"
          class="sidebar-link<?= ($activeView === 'mpl' || $activeView === 'create-mpl') ? '-active' : '' ?>"
        >
          <svg class="sidebar-icon" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 19.38C10.32 18.13 8.5 17.52 6.5 17.52Z"/>
          </svg>
          Material Packing List
        </a>
      </li>

      <li class="sidebar-item">
        <a
          href="?view=orders"
          class="sidebar-link<?= ($activeView === 'orders' || $activeView === 'create-order') ? '-active' : '' ?>"
        >
          <svg class="sidebar-icon" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
            <path d="M3 22V2H21V22Z"/>
          </svg>
          Orders
        </a>
      </li>

    </ul>

    <hr>

    <ul class="sidebar-menu">
      <li class="sidebar-item">
        <a href="/logout.php" class="sidebar-link">
          <svg class="sidebar-icon" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
            <path d="M5.3 20.5C4.8 20.5 4.38 20.32 4.03 19.97Z"/>
          </svg>
          Log out
        </a>
      </li>
    </ul>

  </nav>
</aside>

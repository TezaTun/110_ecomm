<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Link</a></li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        Dropdown
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>

                <?php if (!empty($_SESSION['loginSuccess'])): ?>
                    <li class="nav-item">
                        <span class="nav-link text-dark">
                            👤 <?php echo htmlspecialchars($_SESSION['email']); ?>
                        </span>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="viewProduct.php">View Product</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                <?php endif; ?>
            </ul>

            <?php if (!empty($_SESSION['loginSuccess'])): ?>
                <form class="d-flex" method="get" action="viewProduct.php" role="search">
                    <input name="tsearch" class="form-control me-2" type="search" placeholder="Search">
                    <button name="bsearch" class="btn btn-outline-success" type="submit">Search</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</nav>

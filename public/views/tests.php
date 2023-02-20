<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/tests.css">

    <script src="https://kit.fontawesome.com/ac3844a5b4.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="./public/js/search.js" defer></script>
    <script type="text/javascript" src="./public/js/statistics.js" defer></script>
    <title>TESTS</title>
</head>

<body>
<div class="base-container">
    <nav>
        <img src="public/img/logo.svg">
        <ul>
            <li>
                <i class="fa-solid fa-list"></i>
                <a href="#" class="button">tests</a>
            </li>

        </ul>
    </nav>
    <main>
        <header>
            <div class="search-bar">
                <form>
                    <input placeholder="search test">
                </form>
            </div>
            <div class="add-test">
                <i class="fa-sharp fa-solid fa-lightbulb"></i>
                create test <!-- text-->
            </div>
        </header>
        <section class="tests">
            <?php foreach ($tests as $test): ?>
                <div id="<?= $test->getId(); ?>">
                    <img src="public/uploads/<?= $test->getImage(); ?>">
                    <div>
                        <h2><?= $test->getTitle(); ?></h2>
                        <p><?= $test->getDescription(); ?></p>
                        <div class="social-section">
                            <i class="fas fa-heart"> <?= $test->getLike(); ?></i>
                            <i class="fas fa-minus-square"> <?= $test->getDislike(); ?></i>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>
    </main>
</div>
</body>
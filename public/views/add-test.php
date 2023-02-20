<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/tests.css">

    <script src="https://kit.fontawesome.com/ac3844a5b4.js" crossorigin="anonymous"></script>
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
        <section class="test-form">
            <h1>UPLOAD</h1>
            <form action="addTest" method="POST" ENCTYPE="multipart/form-data">
                <div class="messages">
                    <?php
                    if(isset($messages)){
                        foreach($messages as $message) {
                            echo $message;
                        }
                    }
                    ?>
                </div>
                <input name="title" type="text" placeholder="title">
                <textarea name="description" rows=4 placeholder="description"></textarea>

                <input type="file" name="file"/><br/>
                <button type="submit">send</button>
            </form>
        </section>
    </main>
</div>
</body>
<head>
    <title>Card &ndash; the better way to collect credit cards</title>
    <meta name="viewport" content="initial-scale=1">
    <!-- CSS is included through the card.js script -->
</head>
<body>
    <style>
        .demo-container {
            width: 100%;
            max-width: 350px;
            margin: 50px auto;
        }

        form {
            margin: 30px;
        }
        input {
            width: 200px;
            margin: 10px auto;
            display: block;
        }

    </style>
    <div class="demo-container">
        <div class="card-wrapper"></div>
        <div class="form-container active">
            <form action="">
                <input placeholder="Card number" type="tel" name="number">
                <input placeholder="Full name" type="text" name="name">
                <input placeholder="MM/YY" type="tel" name="expiry">
                <input placeholder="CVC" type="number" name="cvc">
            </form>
        </div>
    </div>
    <{*<script type="text/javascript" src="<{$xoops_url}>/browse.php?Frameworks/jquery/jquery.js"></script>*}>
    <{*<script src="https://code.jquery.com/jquery-migrate-3.0.0.js"></script>*}>
    <{*<script src="<{$mod_url}>/assets//js/card-master/dist/card.js"></script>*}>
    <{*<script src="<{$mod_url}>/assets/js/card-master/dist/jquery.card.js"></script>*}>
    <script>
        new Card({
            form: document.querySelector('form'),
            container: '.card-wrapper'
        });
    </script>
</body>


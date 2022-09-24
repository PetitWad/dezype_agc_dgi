
<div class="container">
    <img src="../public/images/logo.png" alt="" style="width: 20%;">
    <form action="../controller/postPay.php" method="POST">
        <script
            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
            data-key="pk_test_51LlY2LHxPTQ0uXfNHvH6FErV7LOC07Q8zLLy17pURCVJShPWTdoSJnxx2AVl5yYcGmIesbUTYydmQjuNmrltN80W009HM5Lnqm"
            data-amount="<?= $pay ?>"
            data-name="AGC-DGI"
            data-description="Direction Generale des Impots"
            data-locale="auto"
            data-image= <?= "<img src='../public/images/logo.png'>" ?>
            data-currency="USD"
            data-label="Valider | Payer">
        </script>
    </form>
</div>

<style>
    .container{
        position: absolute;
        left: 500px;
        top: 30%;
    }

    form{
        margin-top: 20px;
        margin-left: 15px;
    }
</style>

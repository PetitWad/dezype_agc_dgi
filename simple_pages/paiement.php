<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    <title>paiement</title>
</head>
<body style="
background-image:url('public/images/Re.jpg');
background-attachment: fixed; 
background-size: cover;
">

<div class="container" >
    <form action="">

        <div class="row">

            <div class="col">

                <h3 class="title">Bloc d'Adresse</h3>

                <div class="inputBox">
                    <span>Nom complet :</span>
                    <input type="text" placeholder="Chadique M.Yverson">
                </div>
                <div class="inputBox">
                    <span>email :</span>
                    <input type="email" placeholder="example@exemple.com">
                </div>
                <div class="inputBox">
                    <span>Adresse :</span>
                    <input type="text" placeholder="quartier - rue - lieu">
                </div>
                <div class="inputBox">
                    <span>Pays :</span>
                    <input type="text" placeholder="Haiti">
                </div>

                <div class="flex">
                    <div class="inputBox">
                        <span>Ville :</span>
                        <input type="text" placeholder="Delmas">
                    </div>
                    <div class="inputBox">
                        <span>zip code :</span>
                        <input type="text" placeholder="HT 6120">
                    </div>
                </div>

            </div>

            <div class="col">

                <h3 class="title">paiement</h3>

                <div class="inputBox">
                    <span>cartes acceptables :</span>
                    <img src="public/images/card_img.png" alt="">
                </div>
                <div class="inputBox">
                    <span>Nom sur la carte :</span>
                    <input type="text" placeholder="mr. Scutt Zachary">
                </div>
                <div class="inputBox">
                    <span>Numero de la carte :</span>
                    <input type="number" placeholder="1111-2222-3333-4444">
                </div>
                <div class="inputBox">
                    <span>Mois d'exp :</span>
                    <input type="text" placeholder="january">
                </div>

                <div class="flex">
                    <div class="inputBox">
                        <span>Annee d'exp :</span>
                        <input type="number" placeholder="2022">
                    </div>
                    <div class="inputBox">
                        <span>CVV :</span>
                        <input type="text" placeholder="1234">
                    </div>
                </div>

            </div>
    
        </div>

        <input type="submit" value="Proceder a la verification" class="submit-btn">

    </form>

</div>    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="../js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="../js/datatables-simple-demo.js"></script>   
</body>
</html>

<!--                     Partie CSS                 -->

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500;600&display=swap');

*{
  font-family: 'Poppins', sans-serif;
  margin:0; padding:0;
  box-sizing: border-box;
  outline: none; border:none;
  text-transform: capitalize;
  transition: all .2s linear;
}

.container{
  display: flex;
  justify-content: center;
  align-items: center;
  padding:25px;
  min-height: 100vh;
 
}

.container form{
  padding:20px;
  width:700px;
  background: #fff;
  box-shadow: 0 5px 10px rgba(0,0,0,.1);
}

.container form .row{
  display: flex;
  flex-wrap: wrap;
  gap:15px;
}

.container form .row .col{
  flex:1 1 250px;
}

.container form .row .col .title{
  font-size: 20px;
  color:#333;
  padding-bottom: 5px;
  text-transform: uppercase;
}

.container form .row .col .inputBox{
  margin:15px 0;
}

.container form .row .col .inputBox span{
  margin-bottom: 10px;
  display: block;
}

.container form .row .col .inputBox input{
  width: 100%;
  border:1px solid #ccc;
  padding:10px 15px;
  font-size: 15px;
  text-transform: none;
}

.container form .row .col .inputBox input:focus{
  border:1px solid #000;
}

.container form .row .col .flex{
  display: flex;
  gap:15px;
}

.container form .row .col .flex .inputBox{
  margin-top: 5px;
}

.container form .row .col .inputBox img{
  height: 34px;
  margin-top: 5px;
  filter: drop-shadow(0 0 1px #000);
}

.container form .submit-btn{
  width: 100%;
  padding:12px;
  font-size: 17px;
  background: #27ae60;
  color:#fff;
  margin-top: 5px;
  cursor: pointer;
}

.container form .submit-btn:hover{
  background: #2ecc71;
}   
</style>
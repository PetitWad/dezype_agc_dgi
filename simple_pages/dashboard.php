
  <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Pannel Client</div>
                            <a id="div" class="nav-link" href="simple_user.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                Obligation fiscale S.A
                            </a>
                            <nav>
                    <ul>
                        <li class="menu"><a href="#"><i class="bi bi-box-arrow-in-down-right"></i>&nbsp;&nbsp; Impôt direct</a> 
                            <ul class="sous-menu">
                            <h6>Impôt direct</h6><hr>
                                <li><a href="retenuSource.php"><i class="bi bi-arrow-bar-right"></i>&nbsp; Retenu a la source</a></li>
                                <li><a href="preleveTaxMasseSal.php"><i class="bi bi-arrow-bar-right"></i>&nbsp; Taxe sur la masse salariale</a></li>
                                <li><a href="prelevImpotSociete.php"><i class="bi bi-arrow-bar-right"></i>&nbsp; Impot Societe</a></li>
                            </ul>
                        </li>
                        <li class="menu"><a href="#"><i class="bi bi-box-arrow-in-up-left"></i>&nbsp;&nbsp; Impôt indirect</a> 
                            <ul class="sous-menu">
                                <h6>Impôt indirect</h6><hr>
                                <li> <a href="prelevTaxeChifAffaire.php"><i class="bi bi-arrow-bar-right"></i>&nbsp; Impot sur les chiffre D'affaires</a></li>
                            </ul> 
                        </li>
                        <li class="menu"><a href="#"><i class="bi bi-collection"></i>&nbsp;&nbsp; Taxe communale</a> 
                            <ul class="sous-menu">
                            <h6>Taxe communale</h6><hr>
                                <li><a href="prelevePatente.php"><i class="bi bi-arrow-bar-right"></i>&nbsp;  Patente</a></li>
                            </ul>
                        </ul>
                </nav>

                            <a id="div1" class="nav-link" href="../fonctions/deconnect.php">
                                <div class="sb-nav-link-icon" ><span class="span" style="color:white;"><i class="fas fa-sign-out-alt"></i> Deconnecter</span></div>
                               
                            </a>
                        </div>
                    </div>
                    <div class="sb-nav-link-icon dzype1"><span><a class="dzype" href="https:" target="_blank">DZYPE Developers | Programming team</a></div>

                </nav>
            </div>
<style>
     body{
        margin-top: 40px;
        font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
    }

    nav ul{
        list-style: none;
        font-size: 18px;
    }


    nav ul li,a{
        text-decoration: none;
        color: black;
        padding-bottom: 5px;
    }

    nav a:hover{
        color: white;
    } 


    .sous-menu{
        display: none;
        box-shadow: 0px 1px 3px #ccc;
        background-color: #fff;
        width: 300px;
        position: absolute;
        left: 100px;
        margin-left: 0;
      
    }


   nav > ul li:hover .sous-menu{
        display: block;
        float: left;
        color: black;
        z-index: 1;
    }

    .sous-menu li{
        float: left;
        text-align: left;
        color: black;
    }

    .sous-menu h6{
        color: blue;
        text-align: center;
        padding-top: 12px;
        font-size: 20px;
    }

    .sous-menu li a:hover{
        color: black;
        float: left;
        margin-left: 0px;
    }
 

#div1{
    background-color: red;
    margin-bottom:5px;
}
#div{
    background-color: rgba(72, 58, 58, 0.4);
    margin-bottom:5px;
}

#layoutSidenav_nav{
    position:fixed;
    height:100%;
}
span{
    color:white;
}
.div1:hover{
    transition:0.6s;
    color:black;
}
a{
    text-decoration:none;
    color:gray;
}
.dzype{
    font-size:12px;
    
}
.dzype1{

    margin:5px;
    margin-bottom:15px;
}
</style>



<?  header('Access-Control-Allow-Origin: *'); ?><div class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><img src="img/logo.png"></a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-th-list"></span> 
                        <strong>Menú</strong>
                        <span class="glyphicon glyphicon-chevron-down"></span>
                    </a>
                    <ul class="dropdown-menu opciones scroll-menu pre-scrollable ">
            <li><a href="index.html">Inicio</a></li>
                <li class="opt1"><a href="daily-medication.html">Medicación diaria</a></li>
        <li  class="opt2"><a href="heals.html">Plan de curas</a></li>
          <li class="opt3" ><a href="meals.html">Ingesta</a></li>
               <li   class="opt4"><a href="stools.html">Eliminación</a></li>
                <li class="opt5" ><a href="hygiene.html">Higiene</a></li>
                      <li  class="opt6"><a href="vitalsigns.html">Constantes Vitales</a></li>
            <li  class="opt7"><a href="sleep.html">Sueño</a></li>    <li  style="background-image: url('img/icons/if_question_298853.png');"><a href="questions.html">Preguntas</a></li>
              <li class="opt8" ><a href="messenger.html">Mensajes</a></li>
            <li   class="opt9"><a href="guide.html">Guía Práctica</a></li>
       <div style="height:50px"></div>   </ul>       </li></ul>
              <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-user"></span> 
                        <strong class="username"><?=$_SESSION['username'];?></strong>
                        <span class="glyphicon glyphicon-chevron-down"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <div class="navbar-login">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <p class="text-center">
                                            <span class="profilepic icon-size"></span>
                                        </p>
                                    </div>
                                    <div class="col-lg-12" >
                                        <p class="text-center"><strong class="username2"><?=$_SESSION['username'];?></strong></p>
                                    
                                        <p class="text-center">
                                            <a href="user.html" class="btn btn-primary btn-block btn-sm">Perfil de usuario</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="navbar-login navbar-login-session">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <p>
                                            <a href="javascript:logout()" class="btn btn-danger btn-block">Cerrar Sesion</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div><div class="clearfix"></div>

		
		
	
	
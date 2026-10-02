
<div class="container">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-6">
            <div id="postlist">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="text-center">
                            <div class="row">
                                <div class="col-sm-12" style="background:#183e39!important;text-align:center;padding-top:10px;padding-bottom:10px">
                                    <img width="200px" height="80px" style="text-align:center" src="https://forespama.felmo.pe/img/logo_forestalpama2.png" align="center">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body" style="border:2px solid #183e39!important;padding:10px">
                        
                        <h1>Bienvenido a Aliados PAMA</h1>

						<p>Hola <b>{{$user->name}}</b></p>

                        <p>Tu registro como Aliado PAMA se realizó correctamente.</p>
                        
						<p>Por favor, haga clic en el botón de abajo para verificar su dirección de correo electrónico.</p>
                        <a href="{{ $verificationUrl }}" style="background-color:#198754; color:#ffffff; padding:12px 25px; text-decoration:none; border-radius:5px; display:inline-block;"> Verificar mi correo </a>

                        <p>Si no ha creado una cuenta, no se requiere ninguna acción adicional.</p>
						
						<p> Saludos,<br>
                            <b>FORESTAL PAMA S.A.C.</b>
                        </p>
                        
						<p>	¿No reconoce este registro?</p>
						<p>	Haga click <a href="mailto:julioyamunaque04@forestalpama.pe?subject=NO RECONOZCO EL REGISTRO DE ALIADO PAMA">aquí</a> para alertar a Forestal Pama S.A.C.
						</p>
					
                    </div>
					
					<br />
					<br />
					
                </div>
            </div>
        </div>
    </div>
</div>
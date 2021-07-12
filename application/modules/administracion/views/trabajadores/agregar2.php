<div class="panel-heading">
	<h4 class="panel-title">Agregar <span class="text-bold">Trabajador</span></h4>
	<div class="panel-tools">
		<div class="dropdown">
			<a data-toggle="dropdown" class="btn btn-xs dropdown-toggle btn-transparent-grey">
				<i class="fa fa-cog"></i>
			</a>
			<ul class="dropdown-menu dropdown-light pull-right" role="menu">
				<li>
					<a class="panel-collapse collapses" href="#"><i class="fa fa-angle-up"></i> <span>Collapse</span> </a>
				</li>
				<li>
					<a class="panel-refresh" href="#">
						<i class="fa fa-refresh"></i> <span>Refresh</span>
					</a>
				</li>
				<li>
					<a class="panel-config" href="#panel-config" data-toggle="modal">
						<i class="fa fa-wrench"></i> <span>Configurations</span>
					</a>
				</li>
				<li>
					<a class="panel-expand" href="#">
						<i class="fa fa-expand"></i> <span>Fullscreen</span>
					</a>
				</li>
			</ul>
		</div>
	</div>
</div>
<div class="panel-body">
	<form action="<?php echo base_url() ?>administracion/trabajadores/guardar" role="form" method='POST' class="smart-wizard form-horizontal" id="form">
		<div id="wizard" class="swMain">
			<ul class="anchor">
				<li>
					<a href="#step-1" class="selected" isdone="1" rel="1">
						<div class="stepNumber">
							1
						</div>
						<span class="stepDesc"> General
							<br>
							<small>datos basicos</small> </span>
					</a>
				</li>
				<li>
					<a href="#step-2" class="disabled" isdone="0" rel="2">
						<div class="stepNumber">
							2
						</div>
						<span class="stepDesc"> Otros datos
							<br>
							<small>datos extra</small> </span>
					</a>
				</li>
				<li>
					<a href="#step-3" class="disabled" isdone="0" rel="3">
						<div class="stepNumber">
							3
						</div>
						<span class="stepDesc"> Tecnicos
							<br>
							<small>datos tecnicos</small> </span>
					</a>
				</li>
			</ul>
			
		<div class="stepContainer" style="height: 353px;"><div class="progress progress-xs transparent-black no-radius active content">
				<div aria-valuemax="100" aria-valuemin="0" role="progressbar" class="progress-bar partition-green step-bar" style="width: 25%;">
					<span class="sr-only"> 0% Complete (success)</span>
				</div>
			</div><div id="step-1" class="content" style="display: block;">
				<h2 class="StepTitle">Datos Basicos</h2>
				<div class="form-group">
					<label class="col-sm-3 control-label">
						Rut <span class="symbol required"></span>
					</label>
					<div class="col-sm-7">
						<input type="text" class="form-control" id="username" name="rut" placeholder="">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">
						Nombres <span class="symbol required"></span>
					</label>
					<div class="col-sm-7">
						<input type="text" class="form-control" id="nombres" name="nombres" placeholder="">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">
						Apellidos <span class="symbol required"></span>
					</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="paterno" name="paterno" placeholder="">
					</div>
					<div class="col-sm-3">
						<input type="text" class="form-control" id="materno" name="materno" placeholder="">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">
						Telefono<span class="symbol required"></span>
					</label>
					<div class="col-sm-1">
						<input type="text" class="form-control" id="fono" name="fono1" placeholder="">
					</div>
					<div class="col-sm-6">
						<input type="text" class="form-control" id="fono" name="fono2" placeholder="">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">
						Telefono<span class="symbol"></span>
					</label>
					<div class="col-sm-1">
						<input type="text" class="form-control" id="fono" name="fono3" placeholder="">
					</div>
					<div class="col-sm-6">
						<input type="text" class="form-control" id="fono" name="fono4" placeholder="">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">
						Direccion<span class="symbol"></span>
					</label>
					<div class="col-sm-7">
						<input type="text" class="form-control" id="direccion" name="direccion" placeholder="">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">
						Email<span class="symbol"></span>
					</label>
					<div class="col-sm-7">
						<input type="email" class="form-control" id="email" name="email" placeholder="">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">
						Contraseña <span class="symbol required"></span>
					</label>
					<div class="col-sm-7">
						<input type="password" class="form-control" id="password" name="pass1" placeholder="">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">
						Confirmar Contraseña <span class="symbol required"></span>
					</label>
					<div class="col-sm-7">
						<input type="password" class="form-control" id="password_again" name="pass2" placeholder="">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">
						Region<span class="symbol"></span>
					</label>
					<div class="col-sm-7">
						<select name="select_region" id="select_region">
							<option value="">Seleccione una región...</option>
							<?php foreach($listado_regiones as $lr){ ?>
							<option value="<?php echo $lr->id; ?>"><?php echo $lr->desc_regiones; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">
						Provincia<span class="symbol"></span>
					</label>
					<div class="col-sm-7">
						<select name="select_provincia" id="select_provincia">
							<option value="">Seleccione una provincia...</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">
						Ciudad<span class="symbol"></span>
					</label>
					<div class="col-sm-7">
						<select name="select_ciudad" id="select_ciudad">
							<option value="">Seleccione una ciudad...</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-2 col-sm-offset-8">
						<button class="btn btn-blue next-step btn-block">
							Siguente <i class="fa fa-arrow-circle-right"></i>
						</button>
					</div>
				</div>
			</div><div id="step-2" class="content" style="display: none;">
				<h2 class="StepTitle">Step 2 Content</h2>
				<div class="form-group">
					<label class="col-sm-3 control-label">
						full_name <span class="symbol required"></span>
					</label>
					<div class="col-sm-7">
						<input type="text" class="form-control" id="full_name" name="full_name" placeholder="Text Field">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">
						Phone Number <span class="symbol required"></span>
					</label>
					<div class="col-sm-7">
						<input type="text" class="form-control" id="phone" name="phone" placeholder="Text Field">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">
						Gender <span class="symbol required"></span>
					</label>
					<div class="col-sm-7">
						<label class="radio-inline">
							<div class="iradio_minimal-grey" style="position: relative;"><input type="radio" class="grey" value="f" name="gender" id="gender_female" style="position: absolute; top: -10%; left: -10%; display: block; width: 120%; height: 120%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"><ins class="iCheck-helper" style="position: absolute; top: -10%; left: -10%; display: block; width: 120%; height: 120%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div>
							Female
						</label>
						<label class="radio-inline">
							<div class="iradio_minimal-grey" style="position: relative;"><input type="radio" class="grey" value="m" name="gender" id="gender_male" style="position: absolute; top: -10%; left: -10%; display: block; width: 120%; height: 120%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"><ins class="iCheck-helper" style="position: absolute; top: -10%; left: -10%; display: block; width: 120%; height: 120%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div>
							Male
						</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">
						Address <span class="symbol required"></span>
					</label>
					<div class="col-sm-7">
						<input type="text" class="form-control" id="address" name="address" placeholder="Text Field">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">
						Country <span class="symbol required"></span>
					</label>
					<div class="col-sm-7">
						<select class="form-control" id="country" name="country">
							<option value="">&nbsp;</option>
							<option value="Country 1">Country 1</option>
							<option value="Country 2">Country 2</option>
							<option value="Country 3">Country 3</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">
						City <span class="symbol required"></span>
					</label>
					<div class="col-sm-7">
						<input type="text" class="form-control" id="city" name="city" placeholder="Text Field">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-2 col-sm-offset-3">
						<button class="btn btn-light-grey back-step btn-block">
							<i class="fa fa-circle-arrow-left"></i> Back
						</button>
					</div>
					<div class="col-sm-2 col-sm-offset-3">
						<button class="btn btn-blue next-step btn-block">
							Next <i class="fa fa-arrow-circle-right"></i>
						</button>
					</div>
				</div>
			</div><div id="step-3" class="content" style="display: none;">
				<h2 class="StepTitle">Step 3 Title</h2>
				<div class="form-group">
					<label class="col-sm-3 control-label">
						Card Holder Name <span class="symbol required"></span>
					</label>
					<div class="col-sm-7">
						<input type="text" class="form-control" id="card_name" name="card_name" placeholder="Text Field">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">
						Card Number <span class="symbol required"></span>
					</label>
					<div class="col-sm-7">
						<input type="text" class="form-control" id="card_number" name="card_number" placeholder="Text Field">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">
						CVC <span class="symbol required"></span>
					</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="card_cvc" name="card_cvc" placeholder="Text Field">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">
						Expiration(MM/YYYY) <span class="symbol required"></span>
					</label>
					<div class="col-sm-4">
						<div class="row">
							<div class="col-sm-4">
								<select class="form-control" id="card_expiry_mm" name="card_expiry_mm">
									<option value="">MM</option>
									<option value="01">1</option>
									<option value="02">2</option>
									<option value="03">3</option>
									<option value="04">4</option>
									<option value="05">5</option>
									<option value="06">6</option>
									<option value="07">7</option>
									<option value="08">8</option>
									<option value="09">9</option>
									<option value="10">10</option>
									<option value="11">11</option>
									<option value="12">12</option>
								</select>
							</div>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="card_expiry_yyyy" id="card_expiry_yyyy" placeholder="YYYY">
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">
						Payment Options <span class="symbol required"></span>
					</label>
					<div class="col-sm-7">
						<div class="checkbox">
							<label>
								<div class="icheckbox_minimal-grey" style="position: relative;"><input type="checkbox" class="grey" value="" name="payment" id="payment1" style="position: absolute; top: -10%; left: -10%; display: block; width: 120%; height: 120%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"><ins class="iCheck-helper" style="position: absolute; top: -10%; left: -10%; display: block; width: 120%; height: 120%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div>
								Auto-Pay with this Credit Card
							</label>
						</div>
						<div class="checkbox">
							<label>
								<div class="icheckbox_minimal-grey" style="position: relative;"><input type="checkbox" class="grey" value="" name="payment" id="payment2" style="position: absolute; top: -10%; left: -10%; display: block; width: 120%; height: 120%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"><ins class="iCheck-helper" style="position: absolute; top: -10%; left: -10%; display: block; width: 120%; height: 120%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div>
								Email me monthly billing
							</label>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-2 col-sm-offset-3">
						<button class="btn btn-light-grey back-step btn-block">
							<i class="fa fa-circle-arrow-left"></i> Back
						</button>
					</div>
					<div class="col-sm-2 col-sm-offset-3">
						<button class="btn btn-blue next-step btn-block">
							Next <i class="fa fa-arrow-circle-right"></i>
						</button>
					</div>
				</div>
			</div>
		</div>
		<div class="actionBar"><div class="msgBox"><div class="content"></div><a href="#" class="close">X</a></div><div class="loader">Loading</div><a href="#" class="buttonFinish buttonDisabled">Finish</a><a href="#" class="buttonNext">Next</a><a href="#" class="buttonPrevious buttonDisabled">Previous</a></div></div>
	</form>
</div>
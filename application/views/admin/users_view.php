<body>
<div id="body-wrapper">
		<?php $this->load->view('admin/template/sidebar'); ?>
		<div id="main-content">
			<div class="content-box"><!-- Start Content Box -->
				<div class="content-box-header">
					<h3>Utilizadores</h3>
					<?php if ($action == 'list' || $action == 'add'):?>
					<ul class="content-box-tabs">
						<?php if ($action == 'list'):?><li><a href="#tab1" class="default-tab">Listagem</a></li><?php endif;?> <!-- href must be unique and match the id of target div -->
						<?php if ($action == 'add'):?><li><a href="#tab2" class="default-tab"> Adicionar Utilizador</a> <?php endif;?>
					</ul>	
					<div class="clear"></div>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
					<div class="tab-content <?php if ($action == 'list'):?> default-tab<?php endif;?>" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->	
						<?php if(isset($confirm_message)):?>
						<div class="notification success png_bg">
							<a class="close" href="#">
								<img alt="close" title="Close this notification" src="<?=base_url() ?>public/backend/images/icons/cross_grey_small.png">
							</a>
							<div> <?=$confirm_message; ?></div>
						</div>
						<?php endif;?>
						<?php if(isset($error_mesage)):?>
						<div class="notification error png_bg">
								<a class="close" href="#">
									<img alt="close" title="Close this notification" src="<?=base_url() ?>public/backend/images/icons/cross_grey_small.png">
								</a>
							<div> <?=$error_message; ?></div>
						</div>
						<?php endif;?>
						<?php if ($this->session->flashdata('flashError')):?>
							<div class="notification error png_bg">
								<a href="#" class="close"><img src="<?=base_url() ?>public/backend/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
								<div>
									<?=$this->session->flashdata('flashError'); ?>
								</div>
							</div>
						<?php endif;?>	
						<?php if ($this->session->flashdata('flashConfirm')):?>
							<div class="notification success png_bg">
								<a href="#" class="close"><img src="<?=base_url() ?>public/backend/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
								<div>
									<?=$this->session->flashdata('flashConfirm'); ?>
								</div>
							</div>
						<?php endif;?>			
						<table id="list-elements">
							<thead>
								<tr>
								   <!-- <th><input class="check-all" type="checkbox" /></th> -->
								   <th>ID</th>
								   <th>username</th>
								   <th>email</th>
								   <th>nome</th>
								   <th>sobrenome</th>
								   <th>tipo</th>
								   <th>acções</th>
								</tr>
							</thead>
							 <tfoot>
								<tr>
									<td colspan="6">
										<!-- <div class="bulk-actions align-left">
											<select name="dropdown">
												<option value="option1">Choose an action...</option>
												<option value="option2">Edit</option>
												<option value="option3">Delete</option>
											</select>
											<a class="button" href="#">Apply to selected</a>
										</div> -->
										<?php if(isset($pagination)): ?>
											<div class="pagination">
												<?=$pagination; ?>
											</div>
										<?php endif;?>
										<div class="clear"></div>
									</td>
								</tr>
							</tfoot>
							<tbody>	
							<?php if(isset($records) && is_array($records) && count($records) > 0): ?>
								<?php foreach ($records as $row):?>
									<tr>
										<!-- <td><input type="checkbox" /></td> -->
										<td><?=$row->iduser; ?></td>
										<td><?=utf8_decode($row->username); ?></td>
										<td><?=$row->email; ?></td>
										<td><?=utf8_decode($row->name); ?></td>
										<td><?=utf8_decode($row->surname); ?></td>
										<td><?=$row->type_2; ?></td>
										<td>
											<!-- Icons -->
											<?php $edit_icon 	= "<img src=\"" . base_url() . "public/backend/images/icons/pencil.png\" alt=\"Edit\" />"; ?>
											<?php $delete_icon 	= "<img src=\"" . base_url() . "public/backend/images/icons/cross.png\" alt=\"Delete\" />"; ?>
											<?=anchor("admin/users/edit/$row->iduser", $edit_icon, 'title="Editar"'); ?>
											<?=anchor("admin/users/delete/$row->iduser", $delete_icon, 'title="Apagar" onclick="return confirm(\'Tem a certeza que quer apagar?\')"'); ?> 
										</td>
									</tr>
								<?php endforeach;?>
								<?php else :?>
								<?="Não existem valores a mostrar nesta listagem."; ?>
							<?php  endif;?>
							</tbody>
							
						</table>
					</div> <!-- End #tab1 -->   
					<div class="tab-content <?php if ($action == 'add'):?> default-tab<?php endif;?>" id="tab2">
					<?php 
						$username		= array('name' => 'username', 'class' => 'text-input small-input', 'id' => 'small-input', 'value' => utf8_decode(set_value('username')));
						$password		= array('name' => 'ec_password', 'class' => 'text-input small-input', 'id' => 'small-input');
						$email			= array('name' => 'email', 'class' => 'text-input small-input', 'id' => 'small-input', 'value' => set_value('email'));
						$name			= array('name' => 'name', 'class' => 'text-input small-input', 'id' => 'small-input', 'value' => utf8_decode(set_value('name')));
						$surname		= array('name' => 'surname', 'class' => 'text-input small-input', 'id' => 'small-input', 'value' => utf8_decode(set_value('surname')));
						$options_user 	= array('user' => 'Utilizador', 'super_user' => 'Super Utilizador', 'manager' => 'Manager', 'admin' => 'Administrador'); 
						$website		= array('name' => 'website', 'class' => 'text-input small-input', 'id' => 'small-input', 'value' => set_value('website'));
						$facebook		= array('name' => 'twitter', 'class' => 'text-input small-input', 'id' => 'small-input', 'value' => set_value('facebook'));
						$twitter		= array('name' => 'facebook', 'class' => 'text-input small-input', 'id' => 'small-input', 'value' => set_value('twitter'));
						$submit			= array('class' => 'button', 'id' => 'submit_user', 'value' => 'Adicionar');
					?>
						<?=form_open('admin/users/add');?>
							<?=form_fieldset('Obrigatório'); ?>
								<?=form_label('Username', 'username'); ?>
								<?=form_input($username);?> <?=form_error('username')?>
								<br/>
								<small>Não deve conter espaços</small>
								<br/><br/>
								<?=form_label('Password', 'password'); ?>
								<?=form_password($password);?>
								<br/><br/>
								<?=form_label('Email', 'email'); ?>
								<?=form_input($email);?><?=form_error('email')?>
								<br/><br/>
								<?=form_label('Nome', 'name'); ?>
								<?=form_input($name);?><?=form_error('name')?></span>
								<br/><br/>
								<?=form_label('Sobrenome', 'surname'); ?>
								<?=form_input($surname);?><?=form_error('surname')?></span>
								<br/><br/>
								<?=form_label('Tipo de utilizador', 'type_2'); ?>
								<?=form_dropdown('type_2', $options_user, 'user'); ?>
								<br/><br/>
							<?=form_fieldset_close();?>
							<?=form_fieldset('Opcional'); ?>
								<?=form_label('Website', 'website'); ?>
								<?=form_input($website);?>
								<br/>
								<small>Não precisa de http</small>
								<br/><br/>
								<?=form_label('Facebook username', 'facebook'); ?>
								<?=form_input($facebook);?>
								<br/><br/>
								<?=form_label('Twitter username', 'twitter'); ?>
								<?=form_input($twitter);?>
								<br/>
								<small>Não precisa @</small>
								<br/><br/>
								<?=form_submit($submit);?>
							<?=form_fieldset_close();?>
						<?=form_close();?>
					</div>
				</div> <!-- End .content-box-content -->	
			</div> <!-- End .content-box -->
			<?php elseif ($action == 'edit'):?>
				<ul class="content-box-tabs">
					<li><a href="#tab1" class="default-tab">Editar User</a></li> <!-- href must be unique and match the id of target div -->
				</ul>
				<div class="clear"></div>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
					<div class="tab-content default-tab" id="tab1">
					<?php 
						$username		= array('name' => 'username', 'class' => 'text-input small-input', 'id' => 'small-input', 'value' => set_value('username', utf8_decode($user->username)));
						$password		= array('name' => 'ec_password', 'class' => 'text-input small-input', 'id' => 'small-input');
						$email			= array('name' => 'email', 'class' => 'text-input small-input', 'id' => 'small-input', 'value' => set_value('email', $user->email));
						$name			= array('name' => 'name', 'class' => 'text-input small-input', 'id' => 'small-input', 'value' => set_value('name', utf8_decode($user->name)));
						$surname		= array('name' => 'surname', 'class' => 'text-input small-input', 'id' => 'small-input', 'value' => set_value('surname', utf8_decode($user->surname)));
						$options_user 	= array('user' => 'Utilizador', 'super_user' => 'Super Utilizador', 'manager' => 'Manager', 'admin' => 'Administrador'); 
						$website		= array('name' => 'website', 'class' => 'text-input small-input', 'id' => 'small-input', 'value' => set_value('website', $user->website));
						$facebook		= array('name' => 'twitter', 'class' => 'text-input small-input', 'id' => 'small-input', 'value' => set_value('facebook', $user->facebook));
						$twitter		= array('name' => 'facebook', 'class' => 'text-input small-input', 'id' => 'small-input', 'value' => set_value('twitter', $user->twitter));
						$submit			= array('class' => 'button', 'id' => 'submit_user', 'value' => 'Salvar Alterações');
					?>
						<?=form_open('admin/users/edit/' . $user->iduser);?>
							<?=form_fieldset('Obrigatório'); ?>
								<?=form_label('Username', 'username'); ?>
								<?=form_input($username);?> <?=form_error('username')?>
								<br/>
								<small>Não deve conter espaços</small>
								<br/><br/>
								<?=form_label('Nova Password', 'password'); ?>
								<?=form_password($password);?>
								<br/><br/>
								<?=form_label('Email', 'email'); ?>
								<?=form_input($email);?><?=form_error('email')?>
								<br/><br/>
								<?=form_label('Nome', 'name'); ?>
								<?=form_input($name);?><?=form_error('name')?></span>
								<br/><br/>
								<?=form_label('Sobrenome', 'surname'); ?>
								<?=form_input($surname);?><?=form_error('surname')?></span>
								<br/><br/>
								<?=form_label('Tipo de utilizador', 'type_2'); ?>
								<?=form_dropdown('type_2', $options_user, $user->type_2); ?>
								<br/><br/>
							<?=form_fieldset_close();?>
							<?=form_fieldset('Opcional'); ?>
								<?=form_label('Website', 'website'); ?>
								<?=form_input($website);?>
								<br/>
								<small>Não precisa de http</small>
								<br/><br/>
								<?=form_label('Facebook username', 'facebook'); ?>
								<?=form_input($facebook);?>
								<br/><br/>
								<?=form_label('Twitter username', 'twitter'); ?>
								<?=form_input($twitter);?>
								<br/>
								<small>Não precisa @</small>
								<br/><br/>
								<?=form_submit($submit);?>
							<?=form_fieldset_close();?>
						<?=form_close();?>
					</div>
				</div>
			</div>
			<?php endif;?>
		</div>
	</div>
</body>
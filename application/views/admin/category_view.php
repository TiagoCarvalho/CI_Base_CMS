<body>
<div id="body-wrapper">
		<?php $this->load->view('admin/template/sidebar'); ?>
		<div id="main-content">
			<div class="content-box"><!-- Start Content Box -->
				<div class="content-box-header">
					<h3>Categorias</h3>
					<?php if ($action == 'list' || $action == 'add'):?>
					<ul class="content-box-tabs">
						<?php if ($action == 'list'):?><li><a href="#tab1" class="default-tab">Listagem</a></li><?php endif;?> <!-- href must be unique and match the id of target div -->
						<?php if ($action == 'add'):?><li><a href="#tab2" class="default-tab"> Adicionar Categoria</a> <?php endif;?>
					</ul>	
					<div class="clear"></div>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
					<div class="tab-content <?php if ($action == 'list'):?> default-tab<?php endif;?>" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->	
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
								   <th>Nome</th>
								   <th>Status</th>
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
										<td><?=$row->idcategory; ?></td>
										<td><?=$row->categoryname; ?></td>
										<td><?=$row->categorystatus; ?></td>
										<td>
											<!-- Icons -->
											<?php $edit_icon 	= "<img src=\"" . base_url() . "public/backend/images/icons/pencil.png\" alt=\"Edit\" />"; ?>
											<?php $delete_icon 	= "<img src=\"" . base_url() . "public/backend/images/icons/cross.png\" alt=\"Delete\" />"; ?>
											<?=anchor("admin/category/edit/$row->idcategory", $edit_icon, 'title="Editar"'); ?>
											<?=anchor("admin/category/delete/$row->idcategory", $delete_icon, 'title="Apagar" onclick="return confirm(\'Tem a certeza que quer apagar?\')"'); ?> 
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
						$categoryname			= array('name' => 'categoryname', 'class' => 'text-input small-input', 'id' => 'small-input', 'value' => set_value('categoryname'));
						$categorydescription	= array('name' => 'categorydescription', 'class' => 'text-input textarea wysiwyg', 'id' => 'textarea', 'cols' => '79', 'rows' => '15', 'value' => set_value('categorydescription'));
						$options_category 		= array('active' => 'Activa', 'inactive' => 'inactiva'); 
						$submit					= array('class' => 'button', 'id' => 'submit_category', 'value' => 'Adicionar');
					?>
						<?=form_open('admin/category/add');?>
							<?=form_fieldset('Obrigatório'); ?>
								<?=form_label('Nome', 'categoryname'); ?>
								<?=form_input($categoryname);?> <?=form_error('categoryname')?>
								<br/><br/>
								<?=form_label('Descrição', 'categorydescription'); ?>
								<?=form_textarea($categorydescription);?>
								<br/><br/>
								<?=form_label('Estado', 'categorystatus'); ?>
								<?=form_dropdown('categorystatus', $options_category, 'active'); ?>
								<br/><br/>
							<?=form_fieldset_close();?>
							<?=form_submit($submit);?>
						<?=form_close();?>
					</div>
				</div> <!-- End .content-box-content -->	
			</div> <!-- End .content-box -->
			<?php elseif ($action == 'edit'):?>
				<ul class="content-box-tabs">
					<li><a href="#tab1" class="default-tab">Editar Categoria</a></li> <!-- href must be unique and match the id of target div -->
				</ul>
				<div class="clear"></div>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
					<div class="tab-content default-tab" id="tab1">
					<?php 
						$categoryname			= array('name' => 'categoryname', 'class' => 'text-input small-input', 'id' => 'small-input', 'value' => set_value('categoryname', $category->categoryname));
						$categorydescription	= array('name' => 'categorydescription', 'class' => 'text-input textarea wysiwyg', 'id' => 'textarea', 'cols' => '79', 'rows' => '15', 'value' => set_value('categorydescription', utf8_decode($category->categorydescription)));
						$options_category 		= array('active' => 'Activa', 'inactive' => 'inactiva'); 
						$submit					= array('class' => 'button', 'id' => 'submit_category', 'value' => 'Salvar Alterações');
					?>
						<?=form_open('admin/category/edit/' . $category->idcategory);?>
							<?=form_fieldset('Obrigatório'); ?>
								<?=form_label('Nome', 'categoryname'); ?>
								<?=form_input($categoryname);?> <?=form_error('categoryname')?>
								<br/><br/>
								<?=form_label('Descrição', 'categorydescription'); ?>
								<?=form_textarea($categorydescription);?>
								<br/><br/>
								<?=form_label('Estado', 'categorystatus'); ?>
								<?=form_dropdown('categorystatus', $options_category, utf8_encode($category->categorystatus)); ?>
								<br/><br/>
							<?=form_fieldset_close();?>
							<?=form_submit($submit);?>
						<?=form_close();?>
					</div>
				</div>
			</div>
			<?php endif;?>
		</div>
	</div>
</body>
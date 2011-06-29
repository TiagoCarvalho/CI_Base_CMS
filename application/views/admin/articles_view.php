<body>
<div id="body-wrapper">
		<?php $this->load->view('admin/template/sidebar'); ?>
		<div id="main-content">
			<div class="content-box"><!-- Start Content Box -->
				<div class="content-box-header">
					<h3>Artigos</h3>
					<?php if ($action == 'list' || $action == 'add'):?>
					<ul class="content-box-tabs">
						<?php if ($action == 'list'):?><li><a href="#tab1" class="default-tab">Listagem</a></li><?php endif;?> <!-- href must be unique and match the id of target div -->
						<?php if ($action == 'add'):?><li><a href="#tab2" class="default-tab"> Adicionar Artigo</a> <?php endif;?>
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
								   <th>Titulo</th>
								   <th>Categoria</th>
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
										<td><?=$row->idarticle; ?></td>
										<td><?=$row->articletitle; ?></td>
										<td>
										<?php foreach ($categories as $category):?>
												<?php if ($row->idcategory == $category->idcategory):?>
														<?=$category->categoryname; ?>
												<?php endif;?>
										<?php endforeach;?>
										</td>
										<td><?=$row->articlestatus; ?></td>
										<td>
											<!-- Icons -->
											<?php $edit_icon 	= "<img src=\"" . base_url() . "public/backend/images/icons/pencil.png\" alt=\"Edit\" />"; ?>
											<?php $delete_icon 	= "<img src=\"" . base_url() . "public/backend/images/icons/cross.png\" alt=\"Delete\" />"; ?>
											<?=anchor("admin/articles/edit/$row->idarticle", $edit_icon, 'title="Editar"'); ?>
											<?=anchor("admin/articles/delete/$row->idarticle", $delete_icon, 'title="Apagar" onclick="return confirm(\'Tem a certeza que quer apagar?\')"'); ?> 
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
						$articletitle			= array('name' => 'articletitle', 'class' => 'text-input small-input', 'id' => 'small-input', 'value' => set_value('articletitle'));
						$articleintro			= array('name' => 'articleintro', 'class' => 'text-input textarea', 'id' => 'textarea', 'cols' => '79', 'rows' => '15', 'value' => set_value('articleintro'));
						$articledescription		= array('name' => 'articledescription', 'class' => 'text-input textarea', 'id' => 'textarea', 'cols' => '79', 'rows' => '15', 'value' => set_value('articledescription'));
						$options_article 		= array('active' => 'Activo', 'inactive' => 'inactivo'); 
						$articleimage			= array('name' => 'userfile');
						$submit					= array('class' => 'button', 'id' => 'submit_category', 'value' => 'Adicionar');
					?>
						<?=form_open_multipart('admin/articles/add');?>
							<?=form_fieldset('Obrigatório'); ?>
								<?=form_label('Categoria', 'idcategory'); ?>
									<select name="idcategory">
								 	 	<option value="0">Sem categoria</option>
								 	 	<?php foreach ($categories as $category):?>
								 	 	<option value="<?=$category->idcategory; ?>"><?=$category->categoryname; ?></option>	
								 	 	<?php endforeach;?>
									</select>
									<br/><br/>
								<?=form_label('Titulo', 'articletitle'); ?>
								<?=form_input($articletitle);?> <?=form_error('articletitle')?>
								<br/><br/>
								<?=form_label('Introdução', 'articleintro'); ?> 
								<?=form_textarea($articleintro);?><?=form_error('articleintro')?>
								<br/><br/>
								<?=form_label('Descrição', 'articledescription'); ?>
								<?=form_textarea($articledescription);?>
								<br/><br/>
								<?=form_label('Estado', 'articlestatus'); ?>
								<?=form_dropdown('articlestatus', $options_article, 'active'); ?>
								<br/><br/>
								<?=form_label('Imagem', 'userfile');?>
								<?=form_upload($articleimage);?>
								<br/><br/>
							<?=form_fieldset_close();?>
							<?=form_submit($submit);?>
						<?=form_close();?>
					</div>
				</div> <!-- End .content-box-content -->	
			</div> <!-- End .content-box -->
			<?php elseif ($action == 'edit'):?>
				<ul class="content-box-tabs">
					<li><a href="#tab1" class="default-tab">Editar Artigo</a></li> <!-- href must be unique and match the id of target div -->
				</ul>
				<div class="clear"></div>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content">
					<div class="tab-content default-tab" id="tab1">
					<?php 
						$articletitle			= array('name' => 'articletitle', 'class' => 'text-input small-input', 'id' => 'small-input', 'value' => set_value('articletitle', $article->articletitle));
						$articleintro			= array('name' => 'articleintro', 'class' => 'text-input textarea', 'id' => 'textarea', 'cols' => '79', 'rows' => '15', 'value' => set_value('articleintro', utf8_decode($article->articleintro)));
						$articledescription		= array('name' => 'articledescription', 'class' => 'text-input textarea', 'id' => 'textarea', 'cols' => '79', 'rows' => '15', 'value' => set_value('articledescription', utf8_decode($article->articledescription)));
						$options_article 		= array('active' => 'Activo', 'inactive' => 'Inactivo'); 
						$articleimage			= array('name' => 'userfile');
						$submit					= array('class' => 'button', 'id' => 'submit_article', 'value' => 'Salvar Alterações');
					?>
						<?=form_open_multipart('admin/articles/edit/' . $article->idarticle);?>
							<?=form_fieldset('Obrigatório'); ?>
							<?=form_label('Categoria', 'idcategory'); ?>
									<select name="idcategory">
								 	 	<option value="0">Sem categoria</option>
								 	 	<?php foreach ($categories as $category):?>
								 	 	<option value="<?=$category->idcategory; ?>"<?php if ($category->idcategory == $article->idcategory):?> selected="selected" <?php endif;?>><?=$category->categoryname; ?></option>	
								 	 	<?php endforeach;?>
									</select>
								<br/><br/>
								<?=form_label('Titulo', 'articletitle'); ?>
								<?=form_input($articletitle);?> <?=form_error('articletitle')?>
								<br/><br/>
								<?=form_label('Introdução', 'articleintro'); ?>
								<?=form_textarea($articleintro);?>
								<br/><br/>
								<?=form_label('Descrição', 'articledescription'); ?>
								<?=form_textarea($articledescription);?>
								<br/><br/>
								<?=form_label('Estado', 'articlestatus'); ?>
								<?=form_dropdown('articlestatus', $options_article, utf8_encode($article->articlestatus)); ?>
								<br/><br/>
								<img width="200" src="<?=base_url(); ?>public/images/articles/<?=$article->articleimage; ?>"/>
								<br/>
								<?=form_label('Alterar Imagem', 'userfile');?>
								<?=form_upload($articleimage);?>
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
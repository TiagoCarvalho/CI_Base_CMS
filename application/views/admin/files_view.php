<body>
<div id="body-wrapper">
		<?php $this->load->view('admin/template/sidebar'); ?>
		<div id="main-content">
			<div class="content-box heightauto"><!-- Start Content Box -->
				<div class="content-box-header">
					<h3>Ficheiros</h3>
					<?php if ($action == 'list' || $action == 'add'):?>
					<ul class="content-box-tabs">
						<?php if ($action == 'list'):?><li><a href="#tab1" class="default-tab">Listagem</a></li><?php endif;?> <!-- href must be unique and match the id of target div -->
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
						<?php 
							$userfile = array('name' => 'userfile', 'class' => 'upload', 'id' => 'upload');
							$submit			= array('class' => 'button', 'id' => 'submit_file', 'value' => 'Upload');
						?>
						<!-- 
						<div class="top-form margintop">
							<?=form_open('admin/files/');?>
								<?php $search 	= array('name' => 'search', 'class' => 'text-input small-input', 'id' => 'small-input', 'value' => 'pesquisar', 'size' => '120', 'onclick' => "this.value='';");?>
								<?php $search_b = array('class' => 'button', 'id' => 'submit_search', 'value' => 'ok');?>
								<?=form_input($search);?>
								<?=form_submit($search_b); ?>
							<?=form_close(); ?>
						</div> -->
						<div class="top-form margintop">
							<?=form_open('admin/files/index');?>
								<select name="filter" onchange="this.form.submit();">
									<?php if (!empty($filter)) :?>
										<option>Filtrar por:</option>
										<option <?php if($filter == '.rar'):?>selected<?php endif;?> value=".rar">.rar</option>
										<option <?php if($filter == '.zip'):?>selected<?php endif;?> value=".zip">.zip</option>
										<option <?php if($filter == '.pdf'):?>selected<?php endif;?> value=".pdf">.pdf</option>
										<option <?php if($filter == '.jpg'):?>selected<?php endif;?> value=".jpg">.jpg</option>
										<option <?php if($filter == '.jpeg'):?>selected<?php endif;?> value=".jpeg">.jpeg</option>
										<option <?php if($filter == '.png'):?>selected<?php endif;?> value=".png">.png</option>
										<option <?php if($filter == '.txt'):?>selected<?php endif;?> value=".txt">.txt</option>
									<?php else:?>
										<option>Filtrar por:</option>
										<option value=".rar">.rar</option>
										<option value=".zip">.zip</option>
										<option value=".pdf">.pdf</option>
										<option value=".jpg">.jpg</option>
										<option value=".jpeg">.jpeg</option>
										<option value=".png">.png</option>
										<option value=".txt">.txt</option>
									<?php endif;?>
								</select>
							<?=form_close(); ?>
						</div>
						<div class="top-form margintop">
							<?=form_open('admin/files/index');?>
								<select name="order" onchange="this.form.submit();">
									<?php if (!empty($order)) :?>
										<option>Ordenar por:</option>
										<option <?php if($order == 'date-down'):?>selected<?php endif;?> value="date-down">data ASC</option>
										<option <?php if($order == 'date-up'):?>selected<?php endif;?> value="date-up">data DESC</option>
										<option <?php if($order == 'alpha-down'):?>selected<?php endif;?> value="alpha-down">nome ASC</option>
										<option <?php if($order == 'alpha-up'):?>selected<?php endif;?> value="alpha-up">nome DESC</option>
									<?php else:?>
										<option>Ordenar por:</option>
										<option value="date-down">data ASC</option>
										<option value="date-up">data DESC</option>
										<option value="alpha-down">nome ASC</option>
										<option value="alpha-up">nome DESC</option>
									<?php endif;?>
								</select>
							<?=form_close(); ?>
						</div>
						<div class="top-form margintop">
							<?=form_open('admin/files/');?>
								<?php $clear = array('class' => 'button', 'id' => 'clear_search', 'value' => 'Limpar Filtragem');?>
								<?=form_submit($clear); ?>
							<?=form_close(); ?>
						</div>
						<div class="upload-form">
						<?=form_open_multipart('admin/files/add');?>
							<?=form_fieldset('Novo Ficheiro');?>
								<?=form_label('', 'usefile'); ?>
								<?=form_upload($userfile); ?><?=form_submit($submit) ?><?=form_error('userfile')?>
							<?=form_fieldset_close();?>
						<?=form_close(); ?>
						</div>
						<?php 
							$types = array(
								'.jpg' => 'jpg.png',
								'.jpeg' => 'jpg.png',
								'.png' => 'png.png',
								'.bmp' => 'bmp.png',
								'.gif' => 'gif.png',
								'.mp3' => 'mp3.png',
								'.pdf' => 'pdf.png',
								'.rar' => 'rar.png',
								'.zip' => 'zip.png',
								'.txt' => 'txt.png');
						?>
						<br/><br/>
						<div style="float: left;">
						<?php foreach ($records as $file):?>
							<span class="image" id="gallery">	
								<?php $edit_icon 	= "<img src=\"" . base_url() . "public/backend/images/icons/pencil.png\" alt=\"Edit\" />"; ?>
								<?php $delete_icon 	= "<img src=\"" . base_url() . "public/backend/images/icons/cross.png\" alt=\"Delete\" />"; ?>
								<?php if ($file->filetype == '.jpg' || $file->filetype == '.jpeg' || $file->filetype == '.png' || $file->filetype == '.bmp' || $file->filetype == '.gif'):?>
								<?=anchor("admin/files/edit/$file->idfile", $edit_icon, 'title="Editar" class="edit-icon" style="margin-left: 30px; margin-top: -5px; position: absolute;"'); ?>
								<?php endif; ?>
								<?=anchor("admin/files/delete/$file->idfile", $delete_icon, 'title="Apagar" onclick="return confirm(\'Tem a certeza que quer apagar?\')" class="delete-icon" style="margin-left: 50px; margin-top: -5px; position: absolute;"'); ?> 
								<?php if ($file->filetype == '.jpg' || $file->filetype == '.jpeg' || $file->filetype == '.png' || $file->filetype == '.bmp' || $file->filetype == '.gif' || $file->filetype == '.txt'):?>
									<a href="<?=base_url(); ?>public/images/articles/<?=$file->filename; ?>" title="<?=$file->filename; ?>" rel="modal" class="tt" >
										<img width="64" src="<?=base_url(); ?>public/backend/images/icons/<?=$types[$file->filetype];?>" alt="<?=$file->filename;?>" title="<?=$file->filename;?>"/>
										<span class="tooltip">											
										<span class="middle"><img width="80" src="<?=base_url(); ?>public/images/articles/<?=$file->filename; ?>"/></span>
										</span>
									</a>
								<?php else: ?>
								<img width="64" src="<?=base_url(); ?>public/backend/images/icons/<?=$types[$file->filetype];?>" alt="<?=$file->filename;?>" title="<?=$file->filename;?>"/>
								<?php endif?>
								<small><?=substr($file->filename, 0, 8);?></small>
							</span>
						<?php endforeach;?>
						</div>
						<?php if(isset($pagination)): ?>
							<div class="pagination">
								<?=$pagination; ?>
							</div>
						<?php endif;?>
					</div> <!-- End #tab1 -->   
				</div> <!-- End .content-box-content -->	
			</div> <!-- End .content-box -->
			<?php elseif ($action == 'edit'):?>
				<ul class="content-box-tabs">
					<li><a href="#tab1" class="default-tab">Editar Imagem</a></li> <!-- href must be unique and match the id of target div -->
				</ul>
				<div class="clear"></div>
				</div> <!-- End .content-box-header -->
				<div class="content-box-content heightauto">
					<div class="tab-content default-tab" id="tab1">
					<?php $link = base_url().'public/phpimageeditor/index.php?imagesrc='.urlencode("../images/articles/$file->filename");?>
					<IFRAME SRC="<?=$link; ?>" TITLE="Newsletter" NAME="otherpage" FRAMEBORDER="0" style="width:950px;height: 800px;">Alternate content for non-supporting browsers, probably a link to the same info</IFRAME>
					</div>
				</div>
			</div>
			<?php endif;?>
		</div>
	</div>
</body>
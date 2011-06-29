	<div id="sidebar">
		<div id="sidebar-wrapper">
			<h1 id="sidebar-title"><a href="#">ADMIN</a></h1>
		  
			<!-- Logo (221px wide) -->
			<a href="#"><img id="logo" src="<?=base_url(); ?>public/backend/images/logo.png" alt="Simpla Admin logo" /></a>
		  
			<!-- Sidebar Profile links -->
			<div id="profile-links">
				Olá, <a href="<?=base_url();?>index.php/admin/users/edit/<?=$this->session->userdata('iduser'); ?>" title="Edit your profile"><?=$this->session->userdata('username'); ?></a><br /> 
				<br />
				<a href="#" title="View the Site">Ver site</a> | <?=anchor('admin/login/logout', 'Logout', 'title="Sign Out"') ?>
			</div>        
			<ul id="main-nav">
				<li>
					<?php $dashboard = array('class' => 'nav-top-item no-submenu');?>
					<?=anchor('admin/manage', 'Dashboard', $dashboard); ?>     
				</li>
				<li> 
				<?php if(isset($current_page) && $current_page == 'articles'):?>
					<?php $articles = array('class' => 'nav-top-item current');?>
				<?php else:?>
					<?php $articles = array('class' => 'nav-top-item');?>
				<?php endif;?>
					<?=anchor('', 'Artigos', $articles); ?>
					<ul>
						<li><?=anchor('admin/articles/add', 'Adicionar Artigo'); ?></li>
						<li><?=anchor('admin/articles', 'Ver Artigos'); ?></li> <!-- Add class "current" to sub menu items also -->
					</ul>
				</li>
				<li>
				<?php if(isset($current_page) && $current_page == 'category'):?>
					<?php $menus = array('class' => 'nav-top-item current');?>
				<?php else: ?>
					<?php $menus = array('class' => 'nav-top-item');?>
				<?php endif;?>
					<?=anchor('', 'Categorias', $menus); ?>
					<ul>
						<li><?=anchor('admin/category/add', 'Adicionar Categoria'); ?></li>
						<li><?=anchor('admin/category', 'Gerir Categorias'); ?></li>
					</ul>
				</li>
				<li>
				<?php if(isset($current_page) && $current_page == 'menus'):?>
						<?php $menus = array('class' => 'nav-top-item current');?>
				<?php else: ?>
						<?php $menus = array('class' => 'nav-top-item');?>
				<?php endif;?>
					<?=anchor('', 'Menus', $menus); ?>
					<ul>
						<li><?=anchor('admin/menus/add', 'Adicionar Menu'); ?></li>
						<li><?=anchor('admin/menus', 'Gerir Menus'); ?></li>
					</ul>
				</li>
				
				<li>
					<?php if(isset($current_page) && $current_page == 'users'):?>
						<?php $users = array('class' => 'nav-top-item current');?>
					<?php else:?>
						<?php $users = array('class' => 'nav-top-item');?>
					<?php endif;?>
					<?=anchor('', 'Utilizadores', $users); ?>
					<ul>
						<li><?=anchor('admin/users/add', 'Adicionar Utilizador'); ?></li>
						<li><?=anchor('admin/users/', 'Gerir Utilizadores'); ?></li>
					</ul>
				</li>
				
				<li>
					<?php if(isset($current_page) && $current_page == 'files'):?>
						<?php $files = array('class' => 'nav-top-item current');?>
					<?php else:?>
						<?php $files = array('class' => 'nav-top-item');?>
					<?php endif;?>
						<?=anchor('', 'Ficheiros', $files); ?>
					<ul>
						<li><?=anchor('admin/files/', 'Gerir Ficheiros'); ?></li>
					</ul>
				</li>
			</ul> <!-- End #main-nav -->	
		<p style="text-align: right; padding: 5px;">powered by: <a href="http://www.bloo.pt" target="_blank">bloo.pt</a></p>
		</div>
	</div> <!-- End #sidebar -->
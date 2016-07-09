<!-- Page Title
		============================================= -->
		<section id="page-title">

			<div class="container clearfix">
				<h1><?php if(isset($breadcrump['pagename'])) echo $breadcrump['pagename'];?></h1>
				<ol class="breadcrumb">
					<li><a href="#">Home</a></li>
                                        
                                        <?php if(isset($breadcrump['section'])){ ?>
					<li><a href="#"><?=$breadcrump['section']?></a></li>
                                        <?php } ?>
                                        
                                        <?php if(isset($breadcrump['subsection'])){ ?>
					<li class="active"><?=$breadcrump['subsection']?></li>
                                        <?php } ?>
				</ol>
			</div>

		</section><!-- #page-title end -->
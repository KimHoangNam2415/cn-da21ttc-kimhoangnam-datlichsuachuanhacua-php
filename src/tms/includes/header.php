<style>
													.search-input {
														border: none;
														border-radius: 40px;
														margin-top: -10px;
														padding: 6px 20px;
														height: 30px;
														outline: none;
														font-size: 16px;
														color: #333;
														background: linear-gradient(145deg, #f0f0f0, #e0e0e0);
														box-shadow: inset 2px 2px 5px #bebebe, inset -2px -2px 5px #ffffff;
														transition: all 0.3s ease;
													}

													.search-input::placeholder {
														color: green;
														font-style: italic;
													}

													.search-input:focus {
														background: #fff;
														box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1),
																	0px 1px 3px rgba(0, 0, 0, 0.06);
														color: #000;
													}

													.search-input:hover {
														background: linear-gradient(145deg, #e8e8e8, #d8d8d8);
													}
													</style>
<?php if($_SESSION['login'])
{?>
<div class="top-header">
	<div class="container">
		<ul class="tp-hd-lft wow fadeInLeft animated" data-wow-delay=".5s">
			<li class="hm"><a href="index.php"><i class="fa fa-home"></i></a></li>
			<li class="prnt"><a href="profile.php">Hồ sơ của tôi</a></li>
				<li class="prnt"><a href="change-password.php">Thay đổi mật khẩu</a></li>
			<li class="prnt"><a href="tour-history.php">Lịch sử dịch vụ</a></li>
			
		</ul>
		<ul class="tp-hd-rgt wow fadeInRight animated" data-wow-delay=".5s"> 
			<li class="tol">Chào mừng :</li>				
			<li class="sig"><?php echo htmlentities($_SESSION['login']);?></li> 
			<li class="sigi"><a href="logout.php" >/Đăng xuất</a></li>
        </ul>
		<div class="clearfix"></div>
	</div>
</div><?php } else {?>
<div class="top-header">
	<div class="container">
		<ul class="tp-hd-lft wow fadeInLeft animated" data-wow-delay=".5s">
			<li class="hm"><a href="index.php"><i class="fa fa-home"></i></a></li>
				<li class="hm"><a href="admin/index.php">Đăng nhập quản trị viên</a></li>
		</ul>
		<ul class="tp-hd-rgt wow fadeInRight animated" data-wow-delay=".5s"> 
			<li class="tol">Số điện thoại : 0706 - 839 - 695</li>				
			<li class="sig"><a href="#" data-toggle="modal" data-target="#myModal" >Đăng Ký</a></li> 
			<li class="sigi"><a href="#" data-toggle="modal" data-target="#myModal4" >/ Đăng Nhập</a></li>
        </ul>
		<div class="clearfix"></div>
	</div>
</div>
<?php }?>
<!--- /top-header ---->
<!--- header ---->
<div class="header">
	<div class="container">
		<div class="logo wow fadeInDown animated" data-wow-delay=".5s">
			<a href="index.php">DỊCH VỤ <span>Sữa chửa nhà cửa</span></a>	
		</div>
	
		<div class="lock fadeInDown animated" data-wow-delay=".5s"> 
			<!-- <li><i class="fa fa-lock"></i></li>
            <li><div class="securetxt">SAFE &amp; SECURE </div></li> -->
			<div class="clearfix"></div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<!--- /header ---->
<!--- footer-btm ---->
<div class="footer-btm wow fadeInLeft animated" data-wow-delay=".5s">
	<div class="container">
	<div class="navigation">
			<nav class="navbar navbar-default">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
				  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				  </button>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse nav-wil" id="bs-example-navbar-collapse-1">
					<nav class="cl-effect-1">
						<ul class="nav navbar-nav">
							<li><a href="index.php" style="font-weight: bold; font-size: 18px;" >Trang Chủ</a></li>
							<li><a href="page.php?type=aboutus" style="font-weight: bold; font-size: 18px;">Về Chúng Tôi</a></li>
								<li><a href="package-list.php" style="font-weight: bold; font-size: 18px;">Gói dịch vụ</a></li>
								
								<li><a href="page.php?type=contact" style="font-weight: bold; font-size: 18px;">Liên hệ chúng tôi</a></li>
								<li>
									<div class="search-form">
											<form method="GET" action="" role="search" class="navbar-form navbar-right">
												<div class="form-group">
												

													<input 
													type="text" 
													name="query" 
													class="form-control search-input" 
													placeholder="Bạn tìm gì..." 
													value="<?php echo htmlentities($_GET['query']); ?>"
													>
												</div>
												<button type="submit" class="btn btn-default" style="border-radius:40px; margin-top:-10px; height:30px; padding: 0 10px;">
												<i class="fa fa-search" style="color: green;"></i>
												</button>
											</form>
										</div>
								</li>
								
								<?php if($_SESSION['login'])
{?>
								<!-- <li>Need Help?<a href="#" data-toggle="modal" data-target="#myModal3"> / Write Us </a>  </li> -->
								<?php } else { ?>
								
								<?php } ?>
								<div class="clearfix"></div>

						</ul>
					</nav>
				</div><!-- /.navbar-collapse -->	
			</nav>
		</div>
		
		<div class="clearfix"></div>
	</div>
</div>
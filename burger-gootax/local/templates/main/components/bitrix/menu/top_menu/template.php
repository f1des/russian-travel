<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?php if (!empty($arResult)): ?>

						<div class="main-menu  d-none d-lg-block">
							<nav>
								<ul id="navigation">
									<?php foreach ($arResult as $item): ?>
										<?php if ($item["SELECTED"]): ?>
											<li>
												<a href="<?= $item['LINK'] ?>" style="color: #F2C64D;"><?= $item['TEXT'] ?></a>
											</li>
										<?php else: ?>
											<li>
												<a href="<?= $item['LINK'] ?>"><?= $item['TEXT'] ?></a>
											</li>
										<?php endif; ?>
									<?php endforeach; ?>
								</ul>
							</nav>
						</div>
<?php endif; ?>

<!-- <li><a href="#">blog <i class="ti-angle-down"></i></a>
	<ul class="submenu">
		<li><a href="/blog">blog</a></li>
		<li><a href="/single-blog">single-blog</a></li>
	</ul>
</li>
<li><a href="#">Pages <i class="ti-angle-down"></i></a>
	<ul class="submenu">
		<li><a href="/elements">elements</a></li>
	</ul>
</li> -->


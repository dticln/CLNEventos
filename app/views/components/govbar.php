<?php
namespace App\Views\Components;

use Pure\Utils\Res;?>

<div id="barra-brasil" style="background:#7F7F7F; height: 20px; padding:0 0 0 10px;display:block;">
    <ul id="menu-barra-temp" style="list-style:none;">
        <li style="display:inline; float:left;padding-right:10px; margin-right:10px; border-right:1px solid #EDEDED">
            <a href="http://brasil.gov.br" style="font-family:sans,sans-serif; text-decoration:none; color:white;"><?= Res::str('gov_header'); ?></a>
        </li>
        <li>
            <a style="font-family:sans,sans-serif; text-decoration:none; color:white;" href="http://epwg.governoeletronico.gov.br/barra/atualize.html"><?= Res::str('gov_update'); ?></a>
        </li>
    </ul>
</div>
<div id="barra-ufrgs">
    <div class="wrapper-size">
        <ul>
			<li>
				<a href="http://www.ufrgs.br">
					<?= Res::str('ufrgs_initials'); ?>
				</a>
			</li>
			<li>
				<a href="https://www1.ufrgs.br/catalogoti/">
					<?= Res::str('services_catalog'); ?>
				</a>
			</li>
        </ul>
    </div>
</div>
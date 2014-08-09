<li>
    <a href="<?php echo Yii::app()->getBaseUrl(true) ?>/provider">
        <i class="icon-list-alt"></i>
        <span class="menu-text"> Nhà cung cấp </span>
    </a>
</li>

<li>
    <a href="<?php echo Yii::app()->getBaseUrl(true) ?>/customer">
        <i class="icon-list-alt"></i>
        <span class="menu-text"> Đối tác / Khách hàng </span>
    </a>
</li>

<li>
    <a href="<?php echo Yii::app()->getBaseUrl(true) ?>/category">
        <i class="icon-list-alt"></i>
        <span class="menu-text"> Nhóm hàng </span>
    </a>
</li>

<li>
    <a href="<?php echo Yii::app()->getBaseUrl(true) ?>/product">
        <i class="icon-list-alt"></i>
        <span class="menu-text"> Sản phẩm </span>
    </a>
</li>

<li>
    <a href="#" class="dropdown-toggle">
        <i class="icon-edit"></i>
        <span class="menu-text"> Giao dịch </span>
        <b class="arrow icon-angle-down"></b>
    </a>
    <ul class="submenu">
        <li>
            <a href="<?php echo Yii::app()->getBaseUrl(true); ?>/transfer/receipt">
                <i class="icon-double-angle-right"></i>
                Nhập hàng
            </a>
        </li>
        <li>
            <a href="<?php echo Yii::app()->getBaseUrl(true); ?>/transfer/delivery">
                <i class="icon-double-angle-right"></i>
                Xuất hàng
            </a>
        </li>
    </ul>
</li>

<li>
    <a href="#" class="dropdown-toggle">
        <i class="icon-edit"></i>
        <span class="menu-text"> Đơn hàng </span>
        <b class="arrow icon-angle-down"></b>
    </a>
    <ul class="submenu">
        <li>
            <a href="<?php echo Yii::app()->getBaseUrl(true); ?>/ordernote/receipt">
                <i class="icon-double-angle-right"></i>
                Đơn hàng nhập
            </a>
        </li>
        <li>
            <a href="<?php echo Yii::app()->getBaseUrl(true); ?>/ordernote/delivery">
                <i class="icon-double-angle-right"></i>
                Đơn hàng xuất
            </a>
        </li>
    </ul>
</li>

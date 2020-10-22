<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../../index.php" class="brand-link">
        <!-- <img src="../../dist/img/favicon.ico" alt="Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8"> -->
        <span class="brand-text font-weight-light">Korean Kenya Solar</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="#" class="d-block">Korean Kenya Solar</a>
            </div>
        </div>
        <?php include __DIR__ . '/../utils/conn.php';
        $rights = $conn->query("SELECT * FROM security_groups WHERE id='$group' ")or die($conn->error);
        if (mysqli_num_rows($rights) == 1) {
        $row = $rights->fetch_array();
        $group = $row["group_name"];
        ?>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <?php if(!($row["view_dashboard"] == 0)) { ?>
                    <li class="nav-item has-treeview">
                        <a href="../../index.php" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                <?php } if (!($row["manage_users"] == 0 && $row["manage_user_groups"] == 0)) {?>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-users-cog"></i>
                            <p>
                                Users
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <?php if (!($row["manage_users"] == 0)) { ?>
                                <li class="nav-item">
                                    <a href="../users/users.php" class="nav-link">
                                        <i class="fas fa-user-plus nav-icon"></i>
                                        <p>Users</p>
                                    </a>
                                </li>
                            <?php } if (!($row["manage_user_groups"] == 0)) { ?>
                                <li class="nav-item">
                                    <a href="../users/groups.php" class="nav-link">
                                        <i class="fas fa-briefcase nav-icon"></i>
                                        <p>Roles</p>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } if (!($row["manage_suppliers"] == 0 && $row["manage_customers"] == 0 && $row["manage_customer_groups"] == 0)) {?>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-address-book"></i>
                            <p>
                                Contacts
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <?php if (!($row["manage_suppliers"] == 0)){ ?>
                                <li class="nav-item">
                                    <a href="../contacts/suppliers.php" class="nav-link">
                                        <i class="fas fa-truck-loading nav-icon"></i>
                                        <p>Suppliers</p>
                                    </a>
                                </li>
                            <?php } if (!($row["manage_customers"] == 0)){ ?>
                                <li class="nav-item">
                                    <a href="../contacts/customers.php" class="nav-link">
                                        <i class="far fa-user nav-icon"></i>
                                        <p>Customers</p>
                                    </a>
                                </li>
                            <?php } if (!($row["manage_customer_groups"] == 0)){ ?>
                            <?php }?>
                        </ul>
                    </li>
                <?php }if (!($row["manage_products"] == 0 && $row["manage_categories"] == 0)){?>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-cubes"></i>
                            <p>
                                Products
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <?php if (!($row["manage_products"] == 0)){?>
                                <li class="nav-item">
                                    <a href="../products/list.php" class="nav-link">
                                        <i class="fas fa-list nav-icon"></i>
                                        <p>Products List</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../products/products_create.php" class="nav-link">
                                        <i class="fas fa-plus-circle nav-icon"></i>
                                        <p>Add Products</p>
                                    </a>
                                </li>
                            <?php } if (!($row["manage_categories"] == 0)){ ?>
                                <li class="nav-item">
                                    <a href="../products/categories.php" class="nav-link">
                                        <i class="fas fa-circle nav-icon"></i>
                                        <p>Product Categories</p>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php }if (!($row["receive_stock"] == 0)){?>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>
                                Purchases
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../purchases/list.php" class="nav-link">
                                    <i class="fas fa-list nav-icon"></i>
                                    <p>List Purchases</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="../purchases/purchases_create.php" class="nav-link">
                                    <i class="fas fa-plus-circle nav-icon"></i>
                                    <p>Add Purchase</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php }if (!($row["issue_stock"] == 0 )){?>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-store"></i>
                            <p>
                                Sales
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
							<?php if (!($row["issue_stock"] == 0)){ ?>
                                <li class="nav-item">
                                    <a href="../sales/sales_create.php" class="nav-link">
                                        <i class="fas fa-shipping-fast nav-icon"></i>
                                        <p>Create Sale</p>
                                    </a>
                                </li>
                            <?php } if (!($row["clear_sales"] == 0)){ ?>
                            <?php } if (!($row["clear_sales"] == 0)){ ?>
 							
                            <?php } ?>
                        </ul>
					 <?php if (!($row["adjust_stock"] == 0)){ ?>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-database"></i>
                            <p>
                                Inventory
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../adjustments/list.php" class="nav-link">
                                   <i class="fas fa-plus-circle nav-icon"></i>
                                    <p>Adjust Inventory</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php } }?>

              
                <?php  if (!($row["settings"] == 0)){?>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>
                                Settings
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="../settings/pay_terms.php" class="nav-link">
                                    <i class="fas fa-file nav-icon"></i>
                                    <p>Pay Terms</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php } }?>
                <!--*******************REPORTS Side Nav *****************************-->

                <?php if (!($row["reports"] == 0 )){?>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fas fa-chart-bar"></i>
                        <p>
                            Reports
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">					
                    <?php if (!($row["sales_reports"] == 0 )) { ?>
						<?php } if (!($row["sales_reports"] == 0 )) { ?>
                        <li class="nav-item">
                            <a href="../reports/salessummary.php" class="nav-link">
                                <i class="fa fas fa-hand-holding-usd nav-icon"></i>
                                <p>Sales Summary</p>
                            </a>
                        </li>
						  <?php } if (!($row["sales_reports"] == 0 )) { ?>
                            <li class="nav-item">
                                <a href="../reports/dailysalessummary.php" class="nav-link">
                                    <i class="fa fas fa-file-invoice-dollar nav-icon "></i>
                                    <p>Daily Sales Summary</p>
                                </a>
                            </li>
                        <?php } if (!($row["sales_reports"] == 0 )) { ?>
                            <li class="nav-item">
                                <a href="../reports/salesdetail.php" class="nav-link">
                                    <i class="fas fa-search-dollar nav-icon"></i>
                                    <p>Sales Detail</p>
                                </a>
                            </li>       
                        <?php } if (!($row["sales_reports"] == 0 )) { ?>
                            <li class="nav-item">
                                <a href="../reports/itemsale.php" class="nav-link">
                                    <i class="fa fas fa-tags nav-icon "></i>
                                    <p>Item Sales</p>
                                </a>
                            </li>
 
                        <?php } if (!($row["sales_reports"] == 0 )) { ?>
                        <?php } if (!($row["sales_reports"] == 0 )) { ?>
                        <?php } if (!($row["transfer_reports"] == 0 )) { ?>

                        <?php } if (!($row["transfer_reports"] == 0 )) { ?>
                        <li class="nav-item">
                            <a href="../reports/purchasedet.php" class="nav-link">
                                <i class="fa fas fa-truck nav-icon "></i>
                                <p>Purchase Detail</p>
                            </a>
                        </li>

                        <?php } if (!($row["transfer_reports"] == 0 )) { ?>

                        <?php } if (!($row["transfer_reports"] == 0 )) { ?>

                         <?php } if (!($row["transfer_reports"] == 0 )) { ?>

                        <?php } if (!($row["transfer_reports"] == 0 )) { ?>
						 <?php }?>
                    </ul>
				</li>	
          <?php } ?>

                    <!--**************************************************************** -->
                <li class="nav-item">
                    <a href="../utils/logout.php" class="nav-link">
                        <i class="nav-icon fas fa-undo-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
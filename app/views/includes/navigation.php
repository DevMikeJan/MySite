<nav class = "main_nav">
    <div class = "nav_container">
        <div class = "grid_item1">

        </div>
        <div class = "grid_item2">
            <ul class = "nav_items">
                <li>
                        <a href="<?php echo URLROOT; ?>/" class = "link_a">Home</a>
                </li>
                <li>
                        <a href="<?php echo URLROOT; ?>/Asset" class = "link_a">Assets</a>
                </li>
                <li>
                        <a href="" class = "link_a">Videos</a>
                </li>

                
                <?php if(isLoggedIn()) : ?>
                    <li class = "Dropdown_menu" id = "Dropdown_menu">
                        <span class = "displayUname" id = "displayUname">
                            <?php echo $_SESSION['user_fname'];  ?>
                        </span>
                       
                            <span class="material-symbols-outlined dIcon" id = "dIcon">
                                arrow_drop_down
                            </span>
                            <ul class = "Sub_menu">
                                <li>
                                    <a href="">Download</a>
                                </li>
                                <li>
                                    <a href="">Account</a>
                                </li>
                                <li>
                                    <a href="<?php echo URLROOT; ?>/Logout">Logout</a>
                                </li>
                            </ul>
                    </li>
                    <?php else : ?>
                        <li class = "Login">
                            <a href="<?php echo URLROOT; ?>/Login">Login</a>
                        </li>
                    <?php endif; ?>
                   
                </ul>
            </div>
       
    </div>
</nav>  
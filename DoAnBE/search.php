<div class="hero__search">
    <div class="hero__search__form">
        <form action="shop-grid.php" method="post">

            <input type="text" placeholder="what do you need?" name="q" oninput="load(this)">
            <button type="submit" class="site-btn">SEARCH</button>
        </form>
    </div>
    <div id="container_ajax_search" style="z-index: 3;position: fixed;margin-top: 50px;">
    </div>
    <div class="hero__search__phone">
        <div class="hero__search__phone__icon">
            <i class="fa fa-phone"></i>
        </div>
        <div class="hero__search__phone__text">
            <h5><?php  echo $in4Contact['phone_number']; ?></h5>
            <span>support 24/7 time</span>
        </div>
    </div>
</div>
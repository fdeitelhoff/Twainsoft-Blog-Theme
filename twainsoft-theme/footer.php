<footer id="footer">
<div class="container">
	
		<?php if ( is_active_sidebar('bottom-sidebar-area') ) : ?>
        
            <!-- FOOTER WIDGET BEGINS -->
            
                <section class="row widget">
                    <?php dynamic_sidebar('bottom-sidebar-area') ?>
                </section>
                
            <!-- FOOTER WIDGET END -->
            
        <?php endif; ?>

         <div class="row copyright" >
            <div class="span7" >
            <p>
                &copy; <?php echo get_bloginfo("name"); ?> 2012 - <?php echo date("Y"); ?> 
                | Theme based upon <a href="https://wordpress.org/themes/suevafree" title="WordPress Theme SuevaFree">SuevaFree</a> and is inspired by
				<a href="https://wordpress.org/themes/polar-lite" title="WordPress Theme Polar Lite">Polar Lite</a>. 
            </p>
            </div>
            <div class="span5" >
                <!-- start social -->
                <div class="socials">
                    <?php suevafree_socials(); ?>
                </div>
                <!-- end social -->
            </div>
		</div>
	</div>
</footer>

<?php wp_footer() ?>   

</body>

</html>


<div class="testimonialsWrapper">
<div id="testimonials" class="testimonials">
<?php 
$thedate=zen_get_review();
while (!$thedate->EOF){
?>
  <div>
    <h3><?php echo substr_cut($thedate->fields['customers_name']) ?></h3>
    <p><?php echo $thedate->fields['reviews_text'] ?></p>
  </div>

<?php 
$thedate->MoveNext();
}
?>  
</div>
</div>
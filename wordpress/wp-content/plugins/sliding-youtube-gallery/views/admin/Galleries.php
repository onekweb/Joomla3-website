<!-- Title Page -->
<div class="syg-wrap wrap">
	<?php include 'inc/header.inc.php'; ?>
	<div id="syg-plugin-area">
		
		<!-- User Message -->
		<?php include 'inc/statusBar.inc.php'; ?>
		
		<!-- Title Page -->
		<h3><?php echo SygConstant::BE_MENU_MANAGE_GALLERIES; ?></h3>
		
		<!-- Gallery List -->
		<table cellspacing="0" id="galleries_table">
			<tr id="table_header">
				<th class="id">
					<span>ID</span>
				</th>
				<th class="user_pic">
					<span>AVATAR</span>
				</th>
				<th class="name">
					<span>NAME</span>
				</th>
				<th class="details">
					<span>DETAILS</span>
				</th>
				<th class="type">
					<span>TYPE</span>
				</th>
				<th class="cached">
					<span>CACHED</span>
				</th>
				<th class="action">
					<span>ACTION</span>
				</th>
			</tr>
			<!-- <tr id="syg-loading">
				<td colspan="7">
					
				</td>
			</tr> -->
		</table>
		<div id="paginator-area">
			<ul id="syg-pagination-galleries">
				<?php
				// show page links
				for($i=1; $i<=$this->data['pages']; $i++) {
					echo ($i == 1) ? '<li id="'.$i.'" class="current_page">'.$i.'</li>' : '<li id="'.$i.'">'.$i.'</li>';
				}
				?>
			</ul>
		</div>
		<?php require_once 'inc/contextMenu.inc.php'; ?>
	</div>
</div>
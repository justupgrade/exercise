<?php

?>
<html>
<head>
	<title>Pagination Test</title>
	<style>
		.loading-div {
			
		}
		
		/* Pagination style */
.pagination{margin:0;padding:0;}
.pagination li{
	display: inline;
	padding: 6px 10px 6px 10px;
	border: 1px solid #ddd;
	margin-right: -1px;
	font: 15px/20px Arial, Helvetica, sans-serif;
	background: #FFFFFF;
	box-shadow: inset 1px 1px 5px #F4F4F4;
}
.pagination li a{
    text-decoration:none;
    color: rgb(89, 141, 235);
}
.pagination li.first {
    border-radius: 5px 0px 0px 5px;
}
.pagination li.last {
    border-radius: 0px 5px 5px 0px;
}
.pagination li:hover{
	background: #CFF;
}
.pagination li.active{
	background: #F0F0F0;
	color: #333;
}
	</style>
</head>
<body>
	<div id='loading-div'><strong>Loading...</strong></div>
	<div id='result'></div>
	
	<script type="text/javascript">
		window.onload = function() {
			//load initial data:
			downloadContent(1);
		}

		function downloadContent(page){
			var formdata = new FormData();
			formdata.append('page', page);
			
			var xhr = new XMLHttpRequest();
			xhr.addEventListener('load', onLoadCompleted);
			xhr.open('POST', './pagination.php');
			xhr.send(formdata);
		}

		function onLinkClick(e){
			document.getElementById('loading-div').style.display = 'block';
			if(e.target.getAttribute('data_page') !== null) {
				page = e.target.getAttribute('data_page');
				downloadContent(page);
			}
		}

		function onLoadCompleted(e){
			var response = JSON.parse(e.target.responseText);

			if(response.status === "success") {
				updateResultContainer(response.data, response.pages);
				updateListeners();
			} else {
				alert('error');
			}
		}

		function updateListeners(){
			var links = document.getElementsByTagName('a');
			var count = 0;
			for(var i=0; i < links.length; i++) {
				links[i].addEventListener('click', onLinkClick);
				links[i].IDX = i;
			}
		}

		function updateResultContainer(posts, pages) {
			var out = "";
			for(var i=0; i < posts.length; i++) {
				var record = posts[i];
				out += "<div>";
				out += "ID=" + record.id + ", NAME: " + record.name + "<br>";
				out += "<span>" + record.content + "</span>";
				out += "</div>"
				out += "<hr>";
			}

			document.getElementById('loading-div').style.display = 'none';
			document.getElementById('result').innerHTML = out + pages;
		}
	</script>
</body>
</html>
















<?php
	session_start(); 
	$ticket = $_SESSION["ticket"];
	if($ticket==''){
		header('Location: logon.php');
		die();
	}
?>
<!DOCTYPE html>
<html>
<head>
<?php
	// $ticket = $_SESSION["ticket"];
	// if($ticket==''){
	// 	echo('<meta http-equiv="refresh" content="0; url=logon.php">'); 
	// 	echo('</head></html>');
	// 	die();
	// }
?>
	<meta http-equiv="Content-Type" content="text/html; windows-1251" />
	<title>Arundo CMS</title>
	<link rel="stylesheet" type="text/css" href="ui/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="ui/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="design/style.css">
	
	<script type="text/javascript" src="ui/jquery.min.js"></script>
	<script type="text/javascript" src="ui/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="js/lib/html.js"></script>
	<script type="text/javascript" src="js/lib/jspath.js"></script>
	<script type="text/javascript" src="js/dataSources/iDataSource.js"></script>
	<script type="text/javascript" src="js/arundo.js"></script>
	<script type="text/javascript" src="js/simpleView.js"></script>
	<script type="text/javascript" src="js/rowEditor.js"></script>
	<script type="text/javascript" src="js/treeNodeEditor.js"></script>
	<script type="text/javascript" src="js/catalogEditor.js"></script>
	
	<script type="text/javascript" src="locale/arundo-lang-ru.js"></script>
	<script type="text/javascript" src="js/dataSources/dataSource.js"></script>
	<script type="text/javascript" src="js/mainForm.js"></script>
	
	<script type="text/javascript">
		Arundo.ticket = "<?php echo($_SESSION['ticket']);?>";
	</script>
</head>

<body class="easyui-layout">
	<div data-options="region:'north',border:false" class="header">Arundo CMS</div>
	
	<div data-options="region:'south',border:false" class="footer">&copy; Arundo team, 2013</div>
	
	<div data-options="region:'center',title:''">
	
		<div style="margin:10px 0;"></div>
		<div id="tabsPnl" class="easyui-tabs" data-options="tools:'#tab-tools'" style="width:auto;height:auto;">
		</div>
		<div id="tab-tools">
			<!--a href="javascript:void(0)" class="easyui-linkbutton" data-options="plain:true,iconCls:'icon-add'" onclick="Arundo.view.addPanel()"></a-->
		</div>
		
	
	</div>
</body>
</html>
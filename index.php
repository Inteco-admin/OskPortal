<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, initial-scale=1, user-scalable=no" />
    <meta charset="utf-8">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	
    <link rel="stylesheet" href="https://developer.api.autodesk.com/modelderivative/v2/viewers/7.*/style.min.css" type="text/css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://developer.api.autodesk.com/modelderivative/v2/viewers/7.*/viewer3D.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<script src="https://unpkg.com/linq@3.2.4/linq.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/mustache@4.2.0/mustache.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/cldrjs/0.4.4/cldr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cldrjs/0.4.4/cldr/event.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cldrjs/0.4.4/cldr/supplemental.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cldrjs/0.4.4/cldr/unresolved.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn3.devexpress.com/jslib/21.1.5/css/dx.common.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn3.devexpress.com/jslib/21.1.5/css/dx.light.css" />
    <script src="https://cdn3.devexpress.com/jslib/21.1.5/js/dx.all.js"></script>

    <style>
		/* @font-face {font-family: "Artifakt Element"; src: url("//db.onlinewebfonts.com/t/2ab02c2937018ee7f2ccc346929ccf57.eot"); src: url("//db.onlinewebfonts.com/t/2ab02c2937018ee7f2ccc346929ccf57.eot?#iefix") format("embedded-opentype"), url("//db.onlinewebfonts.com/t/2ab02c2937018ee7f2ccc346929ccf57.woff2") format("woff2"), url("//db.onlinewebfonts.com/t/2ab02c2937018ee7f2ccc346929ccf57.woff") format("woff"), url("//db.onlinewebfonts.com/t/2ab02c2937018ee7f2ccc346929ccf57.ttf") format("truetype"), url("//db.onlinewebfonts.com/t/2ab02c2937018ee7f2ccc346929ccf57.svg#Artifakt Element") format("svg"); }*/

        body {
            margin: 0;
			font-family: "ArtifaktElement", Arial, sans-serif!important;
			min-height: -webkit-fill-available;
        }
		html {
			height: -webkit-fill-available;
		}
        #forgeViewer {
            width: 100%;
            height: 100%;
            margin: 0;
            background-color: #F0F8FF;
			-webkit-box-shadow: 2px 2px 6px 0px rgb(34 60 80 / 20%);
			-moz-box-shadow: 2px 2px 6px 0px rgba(34, 60, 80, 0.2);
			box-shadow: 2px 2px 6px 0px rgb(34 60 80 / 20%);
        }
		#mmenu_screen > .row {
			min-height: 87vh;
			min-height: -webkit-calc(87vh - 90px);
			min-height: -moz-calc(87vh - 90px);
		}

		.flex-fill {
			flex:1 1 auto;
		}
		.break {
			flex-basis: 100%;
			height: 0;
		}
		#dataGrid {
			font-family: 'ArtifaktElement';
			height: -webkit-calc(87vh - 90px);
			height: -moz-calc(87vh - 90px);
			height: 87vh;
			-webkit-box-shadow: 2px 2px 6px 0px rgba(34, 60, 80, 0.2);
			-moz-box-shadow: 2px 2px 6px 0px rgba(34, 60, 80, 0.2);
			box-shadow: 2px 2px 6px 0px rgba(34, 60, 80, 0.2);
		}
		.dx-datagrid{
			font-family: 'ArtifaktElement';
			font-size: 0.75rem;
		}
		.dx-datagrid-table dx-datagrid-table-fixed{
			/*font-size: 0.8rem;*/
		}
		.dx-datagrid-headers .dx-header-row {  
			background-color: #d1edffa1; 
			font-weight: bold;
		}

		.groupBgColor {
			background-color:lightcyan!important;
		}

		#chart-legend {
			width:120px;
			padding:10px;
			/*border:black 1px solid;*/
			font-size: 14px;
			position: absolute;
			top: 5px;
			left: 5px;
			opacity: 0.9;
		}

		.legend-value {
			margin-bottom: 5px;
			display:flex;
			align-items:center;
		}

		.legend-block {
			min-width:20px;
			height:20px;
			margin-right:10px;
			border:#bbb solid 1px;
			background-color:#D3D3D3;
		}
		#levelDisplay{
			position: absolute;
			top: 1rem;
			width: 100%;
			text-align: center;
			font-size: 20px;
			font-weight: bold;
			opacity: 0.7;
		}
		.dx-datagrid-header-panel .dx-toolbar{
			padding: 10px 10px 0px 5px;
		}
		.dx-datagrid-rowsview .dx-data-row .dx-validator.dx-datagrid-invalid.dx-cell-modified::after, .dx-datagrid-rowsview .dx-data-row .dx-validator.dx-datagrid-invalid.dx-datagrid-invalid::after {
			border: 5px solid rgba(217,83,79,.4);
		}
		.dx-datagrid-rowsview .dx-selection.dx-row:not(.dx-row-focused) > td, .dx-datagrid-rowsview .dx-selection.dx-row:not(.dx-row-focused) > tr > td, .dx-datagrid-rowsview .dx-selection.dx-row:not(.dx-row-focused):hover > td, .dx-datagrid-rowsview .dx-selection.dx-row:not(.dx-row-focused):hover > tr > td {
			background-color: #faeedd;
			color: #333;
			border: 1px solid #111;
		}
		.dx-box-item-content {
			font-size: 11px;
		}
		.dx-widget {
			font-family: 'ArtifaktElement';
		}

		.ic-visibility:before {
			content: 'visibility';
		}
		.ic-border_all:before {
			content: 'border_all';
		}
    </style>
</head>

<body>

	<nav class="navbar navbar-light bg-light mb-2" style="height: 70px;">
		<span class="navbar-brand mb-0 h1 mr-auto"><strong>Уровни: </strong><div id="floorFilter_place" class="btn-group ml-1" role="group"></div></span>
		<select class="form-select mr-3" id="projectSelector"></select>
		<select class="form-select" id="modelSelector"></select>
	</nav>
	<div id="mmenu_screen" class="container-fluid main_container d-flex">
		<div class="row flex-fill">
			<div class="col-lg-5 col-md-12 h-100 mmenu_screen--direktaction bg-faded flex-fill ">
				<div id="forgeViewer" class="position-relative"></div>
			</div>
			<div class="col-lg-7 col-sm-12 h-100">
				<div class="row h-100">
					<div class="col-md-12 overflow-auto" id="filterCol">
						<div id="dataGrid"></div>
							
						</div>
					</div>
				</div>
				</div>
			</div>
		</div>
	</div>
<script src="fun.js?s=<?php echo uniqid(); ?>"></script>
<script>
var ajax_token = null;
var ajax_token_expire = null;
modelSelectorItems = [];
prjSelectorItems = [];

function getAjaxToken (){
	$.ajax({
		method: "GET",
		async: false,
		url: "auth.php",
	}).done(function( msg ) {
		ajax_token = msg.access_token
		ajax_token_expire = msg.expires_in
		localStorage.setItem('ajax_token', msg.access_token)
		localStorage.setItem('ajax_token_expire', msg.expires_in)
		localStorage.setItem('ajax_token_date', Math.round(Date.now() / 1000))
	});
}

function checkToken(){
	if (!localStorage.getItem('ajax_token') || localStorage.getItem('ajax_token')  == "undefined"){
		getAjaxToken();
	} else {
		if (Math.round(Date.now() / 1000) > (_.toNumber(localStorage.getItem('ajax_token_date')) + _.toNumber(localStorage.getItem('ajax_token_expire')))) {
			let tokenLife = (_.toNumber(localStorage.getItem('ajax_token_date')) + _.toNumber(localStorage.getItem('ajax_token_expire'))) - Math.round(Date.now() / 1000)
			getAjaxToken();
		} else {
			let tokenLife = (_.toNumber(localStorage.getItem('ajax_token_date')) + _.toNumber(localStorage.getItem('ajax_token_expire'))) - Math.round(Date.now() / 1000)
			ajax_token = localStorage.getItem('ajax_token')
			ajax_token_expire = localStorage.getItem('ajax_token_expire')
		}
	}
}
checkToken()

$.ajax({
	method: "GET",
	url: "projects.json",
	async: false,
}).done(function( data ) {
	$.each(data, function (index, value) {
		prjSelectorItems.push(value);
	})
})


$.ajax({
	method: "GET",
	url: "models.json",
	async: false,
}).done(function( data ) {
	$.each(data, function (index, value) {
		modelSelectorItems.push(value);
	})
})

if (!localStorage.getItem('modelSelected') || localStorage.getItem('modelSelected') === 'undefined'){
	selectedProject = prjSelectorItems[0]["ex"]
	selectedModel = modelSelectorItems[0]
	localStorage.setItem('modelSelected', JSON.stringify(selectedModel))
	prjSelectorItems.forEach(function(elm){
		if(selectedProject){
			$('#projectSelector').append('<option value="' + elm.ex + '" selected>' + elm.name + '</option>');
		} else {
			$('#projectSelector').append('<option value="' + elm.ex + '">' + elm.name + '</option>');
		}
		
	})
	_modelSelectorItems = _.filter(modelSelectorItems,function (item) {return item.prj === selectedProject;})
	_modelSelectorItems.forEach(function(elm){
		$('#modelSelector').append('<option value="' + elm.urn + '">' + elm.name + '</option>');
	})
} else {
	storageSelectedModel = JSON.parse(localStorage.getItem('modelSelected'))
	filtProject = storageSelectedModel.prj
	filtModel = _.filter(modelSelectorItems, {'urn':storageSelectedModel.urn})
	if (filtModel.length > 0 && filtProject != null){
		selPrj = storageSelectedModel.prj
		prjSelectorItems.forEach(function(elm){
			if(elm.ex == selPrj){
				$('#projectSelector').append('<option value="' + elm.ex + '" selected>' + elm.name + '</option>');
			} else {
				$('#projectSelector').append('<option value="' + elm.ex + '">' + elm.name + '</option>');
			}
		
		})

		_modelSelectorItems = _.filter(modelSelectorItems,function (item) {return item.prj === selPrj;})
		_modelSelectorItems.forEach(function(elm){			
			if (storageSelectedModel.urn === elm.urn){
				$('#modelSelector').append('<option value="' + elm.urn + '" selected>' + elm.name + '</option>');
			} else {
				$('#modelSelector').append('<option value="' + elm.urn + '">' + elm.name + '</option>');
			}
		})
		selectedModel = storageSelectedModel
	} else {
		localStorage.removeItem('modelSelected')
		localStorage.setItem('modelSelected', JSON.stringify(modelSelectorItems[0]))
		selectedModel  = modelSelectorItems[0]
		selPrj = selectedModel.prj
		prjSelectorItems.forEach(function(elm){
			if(elm.ex == selPrj){
				$('#projectSelector').append('<option value="' + elm.ex + '" selected>' + elm.name + '</option>');
			} else {
				$('#projectSelector').append('<option value="' + elm.ex + '">' + elm.name + '</option>');
			}
		
		})
		_modelSelectorItems = _.filter(modelSelectorItems,function (item) {return item.prj === selPrj;})
		_modelSelectorItems.forEach(function(elm){			
			if (storageSelectedModel.urn === elm.urn){
				$('#modelSelector').append('<option value="' + elm.urn + '" selected>' + elm.name + '</option>');
			} else {
				$('#modelSelector').append('<option value="' + elm.urn + '">' + elm.name + '</option>');
			}
		})
	}
}

var viewer;
var _viewer = null;     // the viewer
var instanceTree = null;
var rootId = null;
var _dbUID = null;
var _views3D = null;
var filterFromTable = null;
filterDeselectTable = null;
var lookupStatus = [
	{"ID": "Принято", "Name" : "Принято"},
	{"ID": "Не принято", "Name" : "Не принято"},
	{"ID": "В работе", "Name" : "В работе"},
	{"ID": "Выполнено", "Name" : "Выполнено"}
]
var options = {
	env: 'AutodeskProduction',
	api: 'derivativeV2',
    //env: 'AutodeskProduction2',
    //api: 'streamingV2',  // for models uploaded to EMEA change this option to 'derivativeV2_EU'
	bvhOptions: {
		"frags_per_leaf_node": 256,
		"max_polys_per_node": 100
	},
	useConsolidation: true,
    getAccessToken: function(onTokenReady) {
        var token = ajax_token;
        var timeInSeconds = ajax_token_expire; // Use value provided by Forge Authentication (OAuth) API
        onTokenReady(token, timeInSeconds);
    }
};

Autodesk.Viewing.Initializer(options, function() {

    var htmlDiv = document.getElementById('forgeViewer');
    viewer = new Autodesk.Viewing.GuiViewer3D(htmlDiv);
	viewer.setTheme('light-theme');
	var startedCode = viewer.start();
	if (startedCode > 0) {
		console.error('Failed to create a Viewer: WebGL not supported.');
		return;
	}
	viewer.addEventListener(Autodesk.Viewing.SELECTION_CHANGED_EVENT, (selectedObj) => selectComponent(selectedObj.dbIdArray))
	viewer.addEventListener(Autodesk.Viewing.SHOW_ALL_EVENT, function(){ $('#levelDisplay').text('');dataGrid.clearFilter()})
	Autodesk.Viewing.Private.analytics.optOut()
	const keyup = viewer.impl.controls.handleKeyUp.bind(viewer.impl.controls)
	viewer.impl.controls.handleKeyUp=function(e){
	   if (e["code"] == "KeyC"){
		selObjects = viewer.getSelection();
		if (selObjects.length > 0){
			viewer.hide(selObjects)
		}
	   }
	   keyup(e)
	}
	console.log('Initialization complete, loading a model next...');

});

$('#projectSelector').on("change", function(){
	selectedProject = _.find(prjSelectorItems, {'ex':$('#projectSelector').val()})
	_modelSelectorItems = _.filter(modelSelectorItems,function (item) {return item.prj === selectedProject.ex;})
	$('#modelSelector').children().remove().end().append('<option value="" disabled selected>выберите модель</option>')
	_modelSelectorItems.forEach(function(elm){
		$('#modelSelector').append('<option value="' + elm.urn + '">' + elm.name + '</option>');
	})
})

$('#modelSelector').on("change", function(){
			checkToken()
			selectedModel = _.find(modelSelectorItems, {'urn':$('#modelSelector').val()})
			viewer.unloadModel()
			dataGrid = $("#dataGrid").dxDataGrid("instance")
			dataGrid.dispose()
			localStorage.setItem('modelSelected', JSON.stringify(selectedModel))
			documentId = 'urn:' + selectedModel.urn
			Autodesk.Viewing.Document.load(documentId, onDocumentLoadSuccess, onDocumentLoadFailure);
		})

documentId = 'urn:' + selectedModel.urn
Autodesk.Viewing.Document.load(documentId, onDocumentLoadSuccess, onDocumentLoadFailure);
	
function onDocumentLoadSuccess(viewerDocument) {
    var defaultModel = viewerDocument.getRoot().getDefaultGeometry();
    viewer.loadDocumentNode(viewerDocument, defaultModel).then(async function (model) {
		viewer.setSelectionMode(Autodesk.Viewing.SelectionMode.FIRST_OBJECT)
		viewer.setOptimizeNavigation(true)
		viewer.setDisplayEdges(true)
		
		//Low quality
		
		viewer.setQualityLevel(false, false);
		viewer.setGroundShadow(false);
		viewer.setGroundReflection(false);
		viewer.setProgressiveRendering(false);
		
		
		// High quaility
		/*
		viewer.setQualityLevel(true, true);
		viewer.setGroundShadow(true);
		viewer.setGroundReflection(true);
		viewer.setProgressiveRendering(false);
		*/
		
		viewer.setGhosting(false);

		console.time('LoadDoc')
		await afterViewerEvents(
			viewer,
			[
			Autodesk.Viewing.GEOMETRY_LOADED_EVENT,
			Autodesk.Viewing.OBJECT_TREE_CREATED_EVENT
			]
		);
		console.log('Document Load Start');
		allId = [];
		resultList = [];
		instanceTree = await viewer.model.getData().instanceTree;
		rootId = this.rootId = await instanceTree.getRootId()
		allId = getAlldbIds(rootId,instanceTree)
		console.time('getBulkProp')
		await Promise.all(allId.map(dbId => getBulkProp(dbId)))
			.then(function(res) {
				resultList = res[0];
				res = [];
			});
		console.timeEnd('getBulkProp')
		console.log("BulkProp end...")
		console.log('Document Load Success');
		console.timeEnd('LoadDoc')
		console.time('getUniqueValues_Levels')
		_Levels = getUniqueValues(resultList,"ИНТ_Этаж")	
		console.timeEnd('getUniqueValues_Levels')
		
		idMap = Enumerable.from(_dbIdGUID)
		.select( __db => ({
			dbId: __db.dbId,
			GUID: __db.GUID,
			rvtId: __db.Value
			})
		)
		.toArray()

		var template = document.getElementById('floorFilter_tpl').innerHTML;
  		var output = Mustache.render(template, _Levels);
  		document.getElementById('floorFilter_place').innerHTML = output;

		$(".filterButtons").on("click",function(){
			var DataMethod = $(this).data("method")
			var DataValue = $(this).data("value")
			filterFromTable = false
			filterCmd(DataMethod,DataValue)
		})
		$(".btnColor").on("click",function(){
			var DataColor = $(this).data("color")
			setObjColor(DataColor,leafId)
		})
		$('#btnGhost').on("click",function(){
			viewer.setGhosting(!viewer.prefs.ghosting)
		})
		console.time('Coloring')
		startupColoring (selectedModel.modelFilter)
		console.timeEnd('Coloring')
		$(viewer.container).append(toolbarDivHtml);
		$(viewer.container).append(viewerLevelDisplay);
		var filteredState = false
		$("#dataGrid").dxDataGrid({
			dataSource: new DevExpress.data.CustomStore({
				loadMode: "processed",
				cacheRawData: true,
				load: async function() {
					return $.getJSON("db.php?do=midlist&filter="+selectedModel.modelFilter)
						.fail(function() { throw "Data loading error" });
            	},
			}),
			
			showBorders: false,
			showColumnLines: true,
			columnAutoWidth: true,
			rowAlternationEnabled: true,
			filterRow: { visible: true },
			headerFilter: { visible: true },
			wordWrapEnabled: true,
			editing: {
				allowUpdating: true,
				mode: "batch"
        	},
			paging: {
				pageSize: 10,
			},
			pager: {
				visible: true,
				showNavigationButtons: true,
				showPageSizeSelector: true,
				allowedPageSizes: [10,20,50,"all"],
				showInfo: true,
			},
			selection: {
				mode: "multiple",
				allowSelectAll: true,
				showCheckBoxesMode: "always"
			},
			columns: [{
				dataField: "Building",
				caption: "Building",
				width: 90,
				allowEditing: false,
				hidingPriority: 0,
				visible: false,
			},{
				dataField: "Section",
				caption: "Section",
				width: 90,
				allowEditing: false,
				hidingPriority: 1,
				visible: false,
			},{
				dataField: "Level",
				caption: "Уровень",
				width: 90,
				allowEditing: false,
			},{
				dataField: "WorkCode",
				caption: "Код работы",
				width: 100,
				allowEditing: false,
			},{
				dataField: "WorkStatus",
				caption: "Статус",
				width: 100,
				lookup: {
                    dataSource: lookupStatus,
                    valueExpr: "ID",
                    displayExpr: "Name"
                },
				cellTemplate: function(container,item) {
					let cssColor = null
					if (item.value === "Не принято") { cssColor = "#dd222277"}
					if (item.value === "Выполнено") { cssColor = "#32bcad77"}
					if (item.value === "В работе") { cssColor = "#faa21b77"}
					if (item.value === "Принято") { cssColor = "#87b34077"}
					if (cssColor){
						container.css("background", cssColor);
					}
					container.append(item.value);
					
				},
			},{
				dataField: "WorkDate",
				caption: "Выполнение",
				dataType: "date",
				format: 'dd/MM/yyyy',
				width: 120,
				allowGrouping: false,
				validationRules: [{
					type: "required",
					message: "Необходима дата выполнения!"
				}]
			},{
				dataField: "WorkName",
				caption: "Наименование",
				allowEditing: false,
				allowGrouping: false,
				hidingPriority: 2,
			},{
				dataField: "ModelId",
				caption: "ID элемента",
				width: 120,
				allowEditing: false,
				allowGrouping: false,
				visible:false,
			},{
				dataField: "Volume",
				caption: "Обьем",
				width: 100,
				allowEditing: false,
				allowGrouping: false,
			}],
			onRowClick: function(e) {  
				if (e.rowType == "data") {  
					e.event.stopPropagation();  
				}  
			},
			onSelectionChanged: function (e){
				let btn_multi_save = DevExpress.ui.dxButton.getInstance(document.getElementById("multi_save"));
				let btn_multi_date = DevExpress.ui.dxDateBox.getInstance(document.getElementById("multi_date"));
				let btn_multi_status = DevExpress.ui.dxSelectBox.getInstance(document.getElementById("multi_status"));
				if (e["selectedRowKeys"].length > 0){
					filterFromTable = true;
					filterDeselectTable = false
					btn_multi_save.option("disabled",false)
					btn_multi_date.option("disabled",false)
					btn_multi_status.option("disabled",false)
					let dbElm = [];
					e["selectedRowKeys"].forEach( v => {
						let elmdbId = selectByModelId(v.ModelId)
						if (elmdbId.length) { dbElm.push(elmdbId[0].dbId)}
					})
					viewer.select(dbElm);
					viewer.fitToView(viewer.getSelection())
				} else {
					btn_multi_save.option("disabled",true)
					btn_multi_date.option("disabled",true)
					btn_multi_status.option("disabled",true)
					filterFromTable = false
					filterDeselectTable = true
					viewer.clearSelection()
				}
				filterFromTable = false
			},
			onSaving: function (e) {
				e.cancel = true;
				if (e.changes.length) {
					sendBatchRequest('db.php?do=workstatus_update', e.changes).done(function() {
							e.component.refresh(true).done(function() {
								startupColoring(selectedModel.modelFilter);
								viewer.clearSelection();
								e.component.cancelEditData();
							})
						})
				}
        	},
			onToolbarPreparing: function (e) {
            	let toolbarItems = e.toolbarOptions.items;
				var now = new Date();
				toolbarItems.push({
                	widget: "dxButton", 
                	options: { icon: "material-icons ic-border_all", text: "Контур", onClick: function() { viewer.setGhosting(!viewer.prefs.ghosting)} },
                	location: "before"
            	},{
                	widget: "dxButton", 
                	options: { icon: "material-icons ic-visibility", text: "Скрыть/показать всё", onClick: function() {
							if (viewer.getHiddenNodes().length > 0 || viewer.getIsolatedNodes().length > 0){
								console.log(viewer.getHiddenNodes(),viewer.getIsolatedNodes())
								viewer.showAll()
							} else {
								console.log(viewer.getHiddenNodes(),viewer.getIsolatedNodes())
								viewer.hideAll()
							}
						}
					},
                	location: "before"
            	},{
                	widget: "dxDateBox",
					options: {
						type: "date",
						format: 'dd/MM/yyyy',
						value: now,
						disabled: true,
						name: "multi_date",
						elementAttr: {id: "multi_date", class: "multi_date groupBgColor"},
						calendarOptions: {firstDayOfWeek: 1},
					},
					location: "before"
				},{
                	widget: "dxSelectBox",
					options: {
						dataSource: lookupStatus,
						valueExpr: "ID",
						displayExpr: "Name",
						placeholder: "Статус",
						disabled: true,
						name: "multi_status",
						elementAttr: {id: "multi_status", class: "multi_status groupBgColor"},
					},
					location: "before"
				},{
                	widget: "dxButton",
					options: {
						icon: "save",
						disabled: true,
						elementAttr: {id: "multi_save", class: "multi_save groupBgColor"},
						onClick: function() {
							multi_save()
						},
					},
					location: "before"
				});
			}
		})
	});
}

function onDocumentLoadFailure() {
    console.error('Failed fetching Forge manifest');
}
Autodesk.Viewing.UI.PropertyPanel.prototype.onPropertyClick = searchAllByClick


var toolbarDivHtml = '<div id="chart-legend" class="panel-body"><div class="legend-value"><div class="legend-block" style="background-color: #32bcad;"></div>Выполнено</div><div class="legend-value"><div class="legend-block" style="background-color: #87b340;"></div>Принято</div><div class="legend-value"><div class="legend-block" style="background-color: #faa21b;"></div>В работе</div><div class="legend-value"><div class="legend-block" style="background-color: #dd2222;"></div>Не принято</div></div>'
var viewerLevelDisplay = '<div id="levelDisplay"></div>'
</script>

<script id="floorFilter_tpl" type="x-tmpl-mustache">
	{{#.}}
	<button data-method="isolateFloor" data-value="{{.}}" class="btn btn-info btn-sm filterButtons">{{.}}</button>
	{{/.}}
</script>
<script id="floorCategory_tpl" type="x-tmpl-mustache">
	{{#.}}
	<button data-method="isolateCategory" data-value="{{.}}" class="btn btn-primary btn-sm filterButtons">{{.}}</button>
	{{/.}}
</script>

</body>

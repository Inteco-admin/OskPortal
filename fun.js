function subscribeToAllEvents (viewer) {
    for (var key in Autodesk.Viewing) {
        if (key.endsWith("_EVENT")) {
            (function(eventName) {
               viewer.addEventListener(
                    Autodesk.Viewing[eventName],
                    function (event) {
                        console.log(eventName, event);
                    }
                ); 
            })(key);
        }
    }
}

function afterViewerEvents(viewer, events) {
    let promises = [];
    events.forEach(function (event) {
        promises.push(new Promise(function (resolve, reject) {
            let handler = function () {
                viewer.removeEventListener(event, handler);
                resolve();
            }
            viewer.addEventListener(event, handler);
        }));
    });

    return Promise.all(promises)
}

function getAlldbIds(rootId,instanceTree) {
    var alldbId = [];
    if (!rootId) {
      return alldbId;
    }
    var queue = [];
    queue.push(rootId);
    while (queue.length > 0) {
      var node = queue.shift();
      alldbId.push(node);
      instanceTree.enumNodeChildren(node, function(childrenIds) {
        queue.push(childrenIds);
      });
    }
    return alldbId;
}

function getUniqueValues(array, key) {
    var result = new Set();
	if (array.length){
		array.forEach(function(item) {
			if (item.hasOwnProperty(key)) {
				return result.add(item[key]);
			}
		});
		var resultTmp = Array.from(result);
		result = resultTmp.sort(function(a, b) {
		  return a - b;
		});
	} else {
		console.error("getUniqueValues: Empty Array")
	}
    return result;
}

function getBulkProp(id_s){
	return new Promise(resolve => {
		_dbIdGUID = [];
		viewer.model.getBulkProperties([id_s], {
				propFilter: ["Icon","ИНТ_Этаж","Value","GUID","Описание по классификатору"],
				ignoreHidden: true
			}, obj => {
				item = obj[0]
				if ((item["properties"].find(itm=>itm.displayName === "ИНТ_Этаж")) && (item["properties"].find(itm=>itm.displayCategory === "Объект"))){
				//if ((item["properties"].find(itm=>itm.displayValue === "Composite Object")) && (item["properties"].find(itm=>itm.displayName === "ИНТ_Этаж")) && (item["properties"].find(itm=>itm.displayCategory === "Объект"))){
					i = {}
					i["dbId"] = item.dbId;
					for (var index in item.properties) {
						var Prop = item.properties[index];
						i[Prop.displayName] =  Prop.displayValue
					}
					_dbIdGUID.push(i);
				}
				/*obj.forEach(function(item){
					if ((item["properties"].find(itm=>itm.displayValue === "Composite Object")) && (item["properties"].find(itm=>itm.displayName === "ИНТ_Этаж")) && (item["properties"].find(itm=>itm.displayCategory === "Объект"))){
						i = {}
						i["dbId"] = item.dbId;
						for (var index in item.properties) {
							var Prop = item.properties[index];
							i[Prop.displayName] =  Prop.displayValue
						}
						_dbIdGUID.push(i);
					}
				})*/
				resolve(_dbIdGUID);
			}
		)
	})
}

function searchAllByClick(property){
	searchValue = (property.value).toString()
	searchName = (property.name).toString()
	searchCategory = (property.category).toString()
	viewer.search('"'+searchValue+'"', 
		function(dbIds){
		   viewer.model.getBulkProperties(dbIds, {
			propFilter: property.name,
			ignoreHidden: false
			},
		   function(elements){
			let dbIdsToSelect = [];
			for(var i=0; i<elements.length; i++){
				elements[i].properties.forEach(function (prop){
					if ((prop.displayValue.toString() === searchValue) && (prop.displayCategory === searchCategory) && (prop.displayName === searchName)){
						dbIdsToSelect.push(elements[i].dbId);
					} else {
						console.log("NOT Matched element:" + elements[i].dbId)
					}
				})
			}
			viewer.isolate(dbIdsToSelect)
			viewer.fitToView(dbIdsToSelect)
		   })
		}, (e) => {
			   console.log(e);
		}
	)
}

function filterCmd(DataMethod,DataValue){
	switch (DataMethod){
		case "isolateFloor":
			searchName = "ИНТ_Этаж"
			levelDisplay = searchValue = DataValue.toString()
			break;
		case "isolateCategory":
			searchName = "Категория"
			break;
	}
	searchValue = DataValue.toString()
	$(function() {
		viewer.clearSelection()
		$("#dataGrid").dxDataGrid({
			filterSyncEnabled: true,
			filterValue: ["Level", "=", DataValue], 
		})
	});
	viewer.search('"'+searchValue+'"', 
		function(dbIds){
		   viewer.model.getBulkProperties(dbIds, {
				propFilter: searchName,
				ignoreHidden: false
			},
		   	function(elements){
				let dbIdsToSelect = [];
				for(var i=0; i<elements.length; i++){
					elements[i].properties.forEach(function (prop){
						if ((prop.displayValue.toString() === searchValue) && (prop.displayName === searchName) && (prop.displayCategory === "Объект")){
							dbIdsToSelect.push(elements[i].dbId);
						} else {
						}
					})
				}
				$('#levelDisplay').text('Уровень: ' + levelDisplay)
				viewer.isolate(dbIdsToSelect)
				viewer.fitToView(dbIdsToSelect,viewer.model)
		   	})
		}, (e) => {
			   console.log(e);
		}, [searchName]
	)

}

function mapGUIDIds(methodWay,val){

	switch(methodWay){
		case 'id_guid':
			return Enumerable.from(idMap).where(w => Enumerable.from(val).contains(w.dbId)).toArray()
			break;
		case 'guid_id':
			return (Enumerable.from(idMap).where(w => w.GUID == val).toArray())
			break;
		case 'rvt_id':
			return (Enumerable.from(idMap).where(w => Enumerable.from(val).contains(_.toNumber(w.rvtId))).toArray())
			break;
		default:
			return null;
	}
}

function setObjColor (color,obj){
	switch (color){
		case 'red':
			inputColor = new THREE.Color( 0xdd2222 );
			outputColor = new THREE.Vector4(inputColor.r , inputColor.g, inputColor.b, 1);
			obj.forEach(elm=>{
				viewer.setThemingColor(elm,outputColor,null,true);
			})
			break;
		case 'orange':
			inputColor = new THREE.Color( 0xfaa21b );
			outputColor = new THREE.Vector4(inputColor.r , inputColor.g, inputColor.b, 1);
			obj.forEach(elm=>{
				viewer.setThemingColor(elm,outputColor,null,true);
			})
			break;
		case 'green':
			inputColor = new THREE.Color( 0x87b340 );
			outputColor = new THREE.Vector4(inputColor.r , inputColor.g, inputColor.b, 1);
			obj.forEach(elm=>{
				viewer.setThemingColor(elm,outputColor,null,true);
			})
			break;
		case 'cyan':
			inputColor = new THREE.Color( 0x32bcad );
			outputColor = new THREE.Vector4(inputColor.r , inputColor.g, inputColor.b, 1);
			obj.forEach(elm=>{
				viewer.setThemingColor(elm,outputColor,null,true);
			})
			break;
	}
}

function leafDB (dbIdArray){
	var tree = instanceTree
	var cbCount = 0
	var components = []
	var leafId = []
	function getLeafComponentsRec(parent) {
		cbCount++;
		if (tree.getChildCount(parent) != 0) {
			tree.enumNodeChildren(parent, function (children) {
				getLeafComponentsRec(children);
			}, false);
		} else {
			components.push(parent);
		}
		if (--cbCount == 0) return components;
	}

	if (dbIdArray.length){
		dbIdArray.forEach(function (elm) {
			leafId = getLeafComponentsRec(elm);
		})
		return leafId;
	} else {
		leafId = getLeafComponentsRec(dbIdArray);
	}
	return leafId;

}

function selectComponent(dbIdArray){
	var tree = instanceTree
	var cbCount = 0
	var components = []
	dataGrid = $("#dataGrid").dxDataGrid("instance")
	function getLeafComponentsRec(parent) {
		cbCount++;
		if (tree.getChildCount(parent) != 0) {
			tree.enumNodeChildren(parent, function (children) {
				getLeafComponentsRec(children);
			}, false);
		} else {
			components.push(parent);
		}
		if (--cbCount == 0) return components;
	}

	if (dbIdArray.length){
		dbIdArray.forEach(function (elm) {
			leafId = getLeafComponentsRec(elm);
		})
		mappedIDs = mapGUIDIds('id_guid',dbIdArray);
		filterIDs = []
		if (mappedIDs.length > 0){
			mappedIDs.forEach((elm)=>{
				filterIDs.push(elm.rvtId);
			})
		}
		if (!filterFromTable){
			$(function() {
				levelFilter = dataGrid.columnOption("Level").filterValue
				console.log("selectComponent dataGrid filter", filterIDs, "filterFromTable:", filterFromTable, "filterDeselectTable:", filterDeselectTable)
				if (levelFilter) {
					filterValue = [["ModelId", "anyof", filterIDs],["Level", "=", levelFilter]] 
				} else {
					filterValue = ["ModelId", "anyof", filterIDs]
				}
				$("#dataGrid").dxDataGrid({
					filterSyncEnabled: true,
					filterValue: filterValue, 
				})
			});
		} else {
			console.log("selectComponent dataGrid filterFromTable", filterIDs, "filterFromTable:", filterFromTable, "filterDeselectTable:", filterDeselectTable)
		}
	} else {
		leafId = [];
		if (filterFromTable) {
			levelFilter = dataGrid.columnOption("Level").filterValue
			dataGrid.clearFilter()
			if (levelFilter){
				$("#dataGrid").dxDataGrid({
					filterSyncEnabled: true,
					filterValue: ["Level", "=", levelFilter], 
				})
			}
			viewer.fitToView()
			console.warn("Deselect from Table")
		} else {
			console.log("selectComponent dataGrid clear all filters","filterFromTable:", filterFromTable, "filterDeselectTable:", filterDeselectTable)
			if (filterDeselectTable === true ) { console.warn("Deselect from Table") } else { console.warn("Deselect from Viewer") }
			levelFilter = dataGrid.columnOption("Level").filterValue
			let pageIndex = dataGrid.pageIndex()
			dataGrid.clearFilter()
			if (levelFilter){
				$("#dataGrid").dxDataGrid({
					filterSyncEnabled: true,
					filterValue: ["Level", "=", levelFilter],
				})
			}
			dataGrid.clearSelection()
			dataGrid.pageIndex(pageIndex)
		}
		filterDeselectTable = null
	}

}

function startupColoring (filter){
	inputColor = new THREE.Color( 0xeeeeee );
	outputColor = new THREE.Vector4(inputColor.r , inputColor.g, inputColor.b, 1);
	allId.forEach(id => {
		viewer.setThemingColor(id, outputColor, null, true)
	})
	
	viewer.setDisplayEdges(false)
	if (filter){
		filter_url = "&filter="+filter
	} else {
		filter_url = null
	}
	$.get("db.php?do=workstatus&text=В работе"+filter_url,function( data ) {
		if (data){
			ret = [];
			data.forEach(elm => {
				ret.push(elm["ModelId"]);
				if (elm.GUID !== elm["Guid"]){
				}
			})
			idRet = mapGUIDIds('rvt_id',ret);
			ret = [];
			idRet.forEach(elm => {
				ret.push(elm["dbId"])
			})
			setObjColor('orange',ret);
		}
		
	})
	$.get("db.php?do=workstatus&text=Выполнено"+filter_url,function( data ) {
		if (data){
			ret = [];
			data.forEach(elm => {
				ret.push(elm["ModelId"]);
				if (elm.GUID !== elm["Guid"]){
				}
			})
			idRet = mapGUIDIds('rvt_id',ret);
			ret = [];
			idRet.forEach(elm => {
				ret.push(elm["dbId"])
			})
			setObjColor('cyan',ret);
		}
		
	})
	$.get("db.php?do=workstatus&text=Не принято"+filter_url,function( data ) {
		if (data){
			ret = [];
			data.forEach(elm => {
				ret.push(elm["ModelId"]);
				if (elm.GUID !== elm["Guid"]){
				}
			})
			idRet = mapGUIDIds('rvt_id',ret);
			ret = [];
			idRet.forEach(elm => {
				ret.push(elm["dbId"])
			})
			setObjColor('red',ret);
		}
		
	})
	$.get("db.php?do=workstatus&text=Принято"+filter_url,function( data ) {
		if (data){
			ret = [];
			data.forEach(elm => {
				ret.push(elm["ModelId"]);
				if (elm.GUID !== elm["Guid"]){
				}
			})
			idRet = mapGUIDIds('rvt_id',ret);
			ret = [];
			idRet.forEach(elm => {
				ret.push(elm["dbId"])
			})
			setObjColor('green',ret);
		}
		
	})
	viewer.impl.invalidate(true)
	viewer.setDisplayEdges(true)
}

function selectByModelId(modelId){
	return mapGUIDIds('rvt_id',[modelId]);
}

function sendBatchRequest(url, updateData) {
	var d = $.Deferred();
	$.ajax(url, {
		url: "db.php?do=workstatus_update",
		method: "POST",
		data: JSON.stringify(updateData),
		contentType: "application/json",
		xhrFields: { withCredentials: true },
		success: function (textStatus, status,jqXHR) {
			// console.log(textStatus);
		},
	}).done(d.resolve).fail(function (xhr) {
		// console.log(xhr.responseJSON ? xhr.responseJSON.Message : xhr.statusText)
		d.reject(xhr.responseJSON ? xhr.responseJSON.Message : xhr.statusText);
	});
	return d.promise();
}

function validateDate(e) {
	//console.log(e);
	return true;
}

function multi_save(){
	let btn_multi_date = DevExpress.ui.dxDateBox.getInstance(document.getElementById("multi_date"));
	let btn_multi_status = DevExpress.ui.dxSelectBox.getInstance(document.getElementById("multi_status"));
	let dataGrid = $("#dataGrid").dxDataGrid("instance");
	selectedRowsData = dataGrid.getSelectedRowsData();
	postData = []
	selectedRowsData.forEach( row => {
		postData.push( {data:{WorkDate: (btn_multi_date.option('value')).toISOString(),WorkStatus: btn_multi_status.option('value')},key:row});
	})
	sendBatchRequest('db.php?do=workstatus_update', postData).done(function() {
		dataGrid.refresh(true).done(function() {
			dataGrid.deselectAll()
			startupColoring(selectedModel.modelFilter);
			dataGrid.cancelEditData();
		})
	})
}
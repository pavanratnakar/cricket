jQuery(document).ready(function()
{ 
	var teams = $.ajax({url: "include/teamController.php?ref=teamDetails", dataType: "json", cache: true, async: false, success: function(data, result) {if (!result) alert('Failure to retrieve the Products.');}}).responseText;
	var lastsel2;
	jQuery("#team01").jqGrid({
		url:'include/registerController.php?ref=registerUser',
		datatype: "json",
		width:770,
		colNames:['Id', 'MindTree ID', 'Email', 'First Name', 'Last Name' , 'Sex' , 'Skill', 'Rating', 'Description', 'Base Price' , 'Sold Price' , 'Team', 'Increase'],
		colModel:[
			{name:'uid',index:'uid', align:'center',editable:false, sorttype:'int',key:true,hidden:true},
			{name:'mindtreeid',formoptions:{label: 'MindTree ID *'},index:'mindtreeid', align:'center',editable:true,editrules: { required: true },summaryType:'count', summaryTpl : '({0}) Count'},
			{name:'email',index:'email',formoptions:{label: 'Email *'}, align:'center',editable:false,hidden:true, editrules: { required: true, email:true }},
			{name:'firstname',index:'firstname',formoptions:{label: 'First Name *'}, align:"center",editable:true,editrules: { required: true}},
			{name:'lastname',index:'lastname', formoptions:{label: 'Last Name*'}, align:"center",editable:true,editrules: { required: true}},
			{name:'sexselect',index:'sexselect', formoptions:{label: 'Sex *'}, align:"center", editable: true,hidden:true,editrules: { required: true, edithidden:true } ,edittype:"select",editoptions:{value:"1:Male;2:Female"}},
			{name:'choice',index:'choice', formoptions:{label: 'Skill *'}, align:"center",editable: true,hidden:false,editrules: { required: true,edithidden:true } ,edittype:"select",editoptions:{value:"1:Batting;2:Bowling;3:All Rounder"}},
			{name:'rating',index:'rating', formoptions:{label: 'Rating *'}, align:"center",editable: true,hidden:false,editrules: { required: true} ,edittype:"select",editoptions:{value:"1:1-Beginner;2:2-Amature;3:3-Good;4:4-Very Good;5:5-God Like"}},
			{name:'description',index:'description', formoptions:{label: 'Description'}, editable: true,hidden:true,editrules: { required: false, edithidden:true } ,edittype:"textarea", editoptions:{rows:"2",cols:"20"}},
			{name:'base_price',index:'base_price', formoptions:{label: 'Base Price *'},  align:"center", sortable:true, hidden:false, editable: true,editrules: { required: true, number: true, edithidden:false},sorttype:'number',summaryType:'sum'},
			{name:'sold_price',index:'sold_price', formoptions:{label: 'Sold Price *'}, align:"center", sortable:true, hidden:false, editable: true,editrules: { required: true, number: true, edithidden:false},sorttype:'number',summaryType:'sum'},
			{name:'team',index:'team', formoptions:{label: 'Team *'},align:"center", sortable:true, hidden:false, editable: true,edittype: "select", editrules: { required: true }, editoptions: { size: 71,value: (teams.replace('"','')).replace('"','') }},
			{name:'percentage_increase',index:'percentage_increase', formoptions:{label:'Increase'}, align:"center", sortable:false, hidden:false, editable: false},
		],
		rowNum:150,
		rowList:[150,300,450],
		height: 'auto',
		pager: '#pteam01',
		sortname: 'sold_price',
		viewrecords: true,
		sortorder: "desc",
		caption:"Team Selection",
		editurl:"include/registerController.php?ref=registerUserOperation",
		grouping: true,
		groupingView : {
			groupField : ['team'],
			groupColumnShow : [true],
			groupText : ['<b>{0}</b>'],
			groupCollapse : false,
			groupOrder: ['asc'],
			groupSummary : [true],
			showSummaryOnHide: true,
			groupDataSorted : true
		},
		footerrow: true,
		userDataOnFooter: true
	});
	var fn_replyResponse=function(response,postdata)
	{
		var json=response.responseText; //in my case response text form server is "{sc:true,msg:''}"
		var result=eval("("+json+")"); //create js object from server reponse
		if(result.status==false)
		{
			alert(result.message)
		}
		return [result.sc,result.msg,null]; 
	}
	jQuery("#team01").jqGrid('navGrid','#pteam01',
		{add:false, view:true, del:false,edit:false},
		{top:0,closeAfterEdit:false,reloadAfterSubmit:true,closeOnEscape:true,afterSubmit: fn_replyResponse,bottominfo:'* Mandatory fields.'}, // edit options
		{top:0,clearAfterAdd:true,reloadAfterSubmit:true,closeOnEscape:true,afterSubmit: fn_replyResponse,bottominfo:'* Mandatory fields.'}, // add options
		{top:0,reloadAfterSubmit:true,closeOnEscape:true,afterSubmit: fn_replyResponse,bottominfo:'Task can only be deleted by the one who created it.'}, // del options
		{}, // search options
		{closeOnEscape:true} 
	);
	jQuery("#chngroup").change(function()
	{
		var vl = $(this).val();
		if(vl) 
		{
			if(vl == "clear") {
				jQuery("#team01").jqGrid('groupingRemove',true);
			} else {
				jQuery("#team01").jqGrid('groupingGroupBy',vl);
			}
		}
	});
});
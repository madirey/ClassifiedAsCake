YAHOO.example.DynamicData = function()
{
	// Columns
	var myColumnDefs = [
		{key:"id", label:"Id"},
		{key:"name", label:"name"},
		{key:"description", label:"description"}
	];

	var myDataSource = new
		YAHOO.util.DataSource("http://www.monetizemycar.com/newsite2/items/results/");

	myDataSource.responseType = YAHOO.util.DataSource.TYPE_JSON;
	myDataSource.responseSchema = {
		resultsList: "records",
		fields: [
			{key:"id"},
			{key:"name"},
			{key:"description"}
		],
		metaFields: {
			totalRecords: "totalRecords"
		}
	};

	var myRequestBuilder = function(oState, oSelf) {
		oState = oState || {pagination:null};
	
		var page = oState.pagination.page;
		return page;
	};

	var myConfigs = {
		initialRequest: "1",
		dynamicData: true,
		paginator: new YAHOO.widget.Paginator({ rowsPerPage:10 }),
		generateRequest: myRequestBuilder };
	
	var myDataTable = new YAHOO.widget.DataTable("dynamicdata", myColumnDefs,
		myDataSource, myConfigs);
	myDataTable.hideColumn("id");

	myDataTable.handleDataReturnPayload = function(oRequest, oResponse, oPayload) {
		oPayload.totalRecords = oResponse.meta.totalRecords;
		return oPayload;
	}

	return {
		ds: myDataSource,
		dt: myDataTable
	};
} ();

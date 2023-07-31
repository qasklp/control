<?php

	//СТОРІНКА СКАНУВАННЯ
	//

	define("event", "Event:");
	define("ready", "The system is ready for scanning");
	define("scan", "Scan");
	define("exit1", "Exit");
	define("exit2", "Exit:");
	define("unknowbar", "The ticket is not in the database");
	define("entrance", "Hall entrance:");
	define("again", "Repeat scan:");
	define("noinhall", "There is no ticket in the hall");
	define("wrongz", "Wrong entrance area");
	define("noresp", "The server is not responding!");
	define("nobar", "No barcode entered");
	define("row", "Row:");
	define("place", "Place:");
	define("zone", "Zone:");
	define("inv", "INVITATION");

	//MENU

	define("Events", "Events");
	define("Halls", "Halls");
	define("Log", "Log");
	define("Monitor", "Online monitor");
	define("Stat", "Statistics");
	define("Report", "Reports");
	define("Guests", "Guests List");
	define("Users", "Users");
	define("Role", "Role management");
	define("Settings", "Settings");


	//EVENTS
	//
	define("events_list", "Events list");
	define("active", "Active event:");
	define("add_event", "Add event");
	define("active2", "Active");
	define("venue", "Venue:");
	define("date", "Event date:");
	define("totalbr", "Barcodes in the database:");
	define("inzone", "Total in zone");
	define("csv", "csv file structure");
	define("csvload", "Upload file *.csv");
	define("csvload2", "File *.csv");
	define("upload", "Upload");
	define("addtk", "Additional tickets");
	define("clearbr", "Clear the barcode database");
	define("hallout", "All barcodes are not in the hall");
	define("delev", "Delete event");

	//HALL
	//
	define("hallscv", "Download the hall structure file *.csv");
	define("addhall", "Add location");
	define("addzone", "Add zone");
	define("hallname", "Location name");
	define("halladdr", "Location address");
	define("backimg", "Background picture");
	define("loca", "Location: ");
	define("locacrt", " created!");
	define("locaerr", "Error creating location!");
	define("zonaempty", "Zone name not entered!");


	//LOG
	//
	define("renewlog", "Update the log");
	define("clerlog", "Clear event log?");
	define("clerlog2", "Clear event log");

	//MONITOR
	//
	define("inhall", "Ticket in the hall");
	define("notinhall", "Ticket is not in the hall");
	define("invate", "Invitation");

	//REPORTS
	//
	define("reports", "Event reports");
	define("reportname", "Report name");
	define("reportload", "Report load");
	define("totalreport", "General report on the event");
	define("barbasestat", "Database of barcodes with login status");
	define("enterlog", "Log entry to the event");
	define("notonevent", "Barcodes that did not go to the event");
	define("basesave", "The barcode database has been saved!");
	define("basesavecsv", "Database of barcodes in csv format has been saved!");
	define("logsave", "Scan log saved!");
	define("nonscanbr", "Barcodes that were not scanned has been saved!");
	define("statall", "The general statistics file has been created!");


	//
	//Menu
	define("load_guests", "Load list");
	define("guests_list", "List");
	define("guests_log", "Log");
	define("guests_scan", "Scan");
	//Pages
	define("guests_log_title", "Guests log");


	//ROLES
	//
	define("rolemanage", "Role management");
	define("roleadd", "Add a role");
	define("onlyscan", "Only scan!");


	//SYSTEM USERS
	//
	//
	define("sysusers", "System users");
	define("adduser", "Add user");



	//SETTINGS
	//
	define("sysset", "System settings");
	define("logo", "System logo");
	define("invmark", "Marker 'Invite'");
	define("salemark", "Marker 'Who sold'");
	define("ribmark", "Marker 'Zone ribbon'");
	define("exitmark", "Scan to exit");
	define("fanprocmark", "The percentage of filling the fanzone");
	define("salelogomark", "Show the seller's logo in log");
	define("audio", "Audio accompaniment");
	define("audiotype", "Type of audio");
	define("langsys", "System language");
	define("ukrlang", "Ukrainian language");
	define("englang", "English language");
	define("female", "Female voice");
	define("male", "Male voice");
	define("setsave", "Settings saved!");
	define("setsave2", "Save");

	//DIALOG WINDOWS
	//
	define("addzone", "Add zone");
	define("zonelist", "Zone list");
	define("zonename", "Zone name");
	define("fanzone", "Fanzone");

	//DIALOG BTN
	//
	define("addbtn", "ADD");

?>
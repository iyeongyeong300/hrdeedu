<%

set UploadForm	= Server.CreateObject("SiteGalaxyUpload.Form")

UpFile				= UploadForm("Filedata")
callback_func = UploadForm("callback_func")
		

%>

<%=UpFile%>
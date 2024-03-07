<%
'#####################################################
' Bgn : 디렉토리 생성
Sub createDir(strPath)
	set OBJFSO = CreateObject("Scripting.FileSystemObject")

	if not OBJFSO.folderexists(strPath) then
		OBJFSO.createfolder(strPath)
	end if
	Set OBJFSO = Nothing
End Sub
' End : 디렉토리 생성
'#####################################################
'## 업로드 컴포넌트
set UploadForm	= Server.CreateObject("SiteGalaxyUpload.Form")

YMDHIS = Year(Now)
if len(Month(Now)) < 2 then YMDHIS = YMDHIS & "0" & Month(Now) else YMDHIS = YMDHIS & Month(Now) end if
FileName = ""
ROOT_UPLOAD = Request.ServerVariables("APPL_PHYSICAL_PATH") & "\upload\webedit\" & YMDHIS
ROOT_HTTP = "/upload/webedit/" & YMDHIS
'## 디렉토리 생성
call createDir(ROOT_UPLOAD)
mode = "WriteOK"
select case mode
	case "WriteOK"
		'===========================================================================
		'업로드
		'===========================================================================
		'##-- Form값 받기
		UpFile				= UploadForm("Filedata")
		callback_func = UploadForm("callback_func")
		
		'파일 업로드
		if len(UpFile) > 0 then
			If UploadForm("Filedata").size > 20971520 Then
				response.write("<script>" & chr(13))
				response.write("alert('20MByte 이상은 올리실 수 없습니다.');" & chr(13))
				response.write("</script>" & chr(13))
				response.end
			end if
			'파일명 변경
			Ext	= LCase(Mid(UpFile, InstrRev(UpFile, ".") + 1) )
			if not(Ext = "jpg" or Ext = "gif" or Ext = "bmp" or Ext = "png") then
				response.write("<script>" & chr(13))
				response.write("alert('이미지 파일만 업로드 가능합니다.');" & chr(13))
				response.write("</script>" & chr(13))
				response.end
			end if
			if len(Day(date)) < 2 then YMDHIS = YMDHIS & "0" & Day(date) else YMDHIS = YMDHIS & Day(date) end if
			if len(Hour(Now)) < 2 then YMDHIS = YMDHIS & "0" & Hour(Now) else YMDHIS = YMDHIS & Hour(Now) end if
			if len(Minute(Now)) < 2 then YMDHIS = YMDHIS & "0" & Minute(Now) else YMDHIS = YMDHIS & Minute(Now) end if
			if len(Second(Now)) < 2 then YMDHIS = YMDHIS & "0" & Second(Now) else YMDHIS = YMDHIS & Second(Now) end If

			FileName = YMDHIS & "." & Ext
			UploadForm("Filedata").saveas ROOT_UPLOAD & "\" & FileName
		end if
		set UploadForm = nothing
		if len(FileName) > 0 then
			'response.write("<script>" & chr(13))
			'response.write("parent.FUN_UpLoadOk('" & ROOT_HTTP & "/" & FileName & "');" & chr(13))
			'response.write("</script>" & chr(13))
			'response.end

			Response.Redirect "callback.html?callback_func="&callback_func&"&bNewLine=true&sFileName="&FileName&"&sFileURL="&ROOT_HTTP&"/"&FileName

		end if
end select
%>

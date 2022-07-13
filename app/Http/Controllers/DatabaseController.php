<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Mpdf\Mpdf;
use PhpOffice\PhpWord\TemplateProcessor;
use Spatie\GoogleCalendar\Event;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


/**
 * Controller principale del webticket
 * Class HomeController
 * @package App\Http\Controllers
 */

class DatabaseController extends Controller{


    public static function crea_xwpreport(){


        DB::statement("If	dbo.afn_du_IsTable('xWPReport') = 0 Begin
CREATE TABLE xWPReport (
		Id_xWPReport        int Identity(1,1) Not Null,
		Cd_CF               char(7)           Not Null,
		Cd_WPReport         varchar(10)       Not Null,
		Descrizione         varchar(80)       Not Null,
		Nome_Report         varchar(200)          Null,
		Report              image             Not Null,
		WPDefault_Report    bit               Not Null CONSTRAINT DF_xWPReport_WPDefault_Report DEFAULT ((0)),
		Nome_ReportE        varchar(200)          Null CONSTRAINT DF_xWPReport_Nome_ReportE DEFAULT (''),
		Nome_ReportP        varchar(200)          Null CONSTRAINT DF_xWPReport_Nome_ReportP DEFAULT (''),
		TimeIns             smalldatetime     Not Null CONSTRAINT DF_xWPReport_TimeIns DEFAULT (getdate()),
		TimeUpd             smalldatetime     Not Null CONSTRAINT DF_xWPReport_TimeUpd DEFAULT (getdate()),
		UserIns             varchar(48)       Not Null CONSTRAINT DF_xWPReport_UserIns DEFAULT (host_name()),
		UserUpd             varchar(48)       Not Null CONSTRAINT DF_xWPReport_UserUpd DEFAULT (host_name()),
		Ts                  timestamp         Not Null,
		Nome_ReportEP       varchar(200)          Null,
		RI_EI               varchar(200)          Null,
		RI_EE               varchar(200)          Null,
		RI_PI               varchar(200)          Null,
		RI_PE               varchar(200)          Null,
		RI_COLLO            varchar(200)          Null,
		RI_COLLO_QUALITA    varchar(200)          Null,
		RI_ETICHETTA_PEDANA varchar(200)          Null,
		RI_ETICHETTA_INTERNA varchar(200)          Null,
		RI_PEDANA           varchar(200)          Null,
		CONSTRAINT PK_xWPReport PRIMARY KEY NONCLUSTERED(Id_xWPReport),
		CONSTRAINT Uk_xWPReport_Cd_CF UNIQUE NONCLUSTERED(Cd_CF),
		CONSTRAINT Uk_xWPReport_cd_WPReport UNIQUE NONCLUSTERED(Cd_WPReport),
		CONSTRAINT FK_XWPReport_CF FOREIGN KEY (Cd_CF) REFERENCES CF (Cd_CF),
		CONSTRAINT CK_xWPReport_Cd_WPReport CHECK ([Cd_WPReport]<>'')
)
End Else Begin

	Exec asp_du_AddAlterColumn 'xwpreport', 'Cd_CF'              , 'char(7)           Not Null', '', ''
	Exec asp_du_AddAlterColumn 'xwpreport', 'Cd_WPReport'        , 'varchar(10)       Not Null', '', ''
	Exec asp_du_AddAlterColumn 'xwpreport', 'Descrizione'        , 'varchar(80)       Not Null', '', ''
	Exec asp_du_AddAlterColumn 'xwpreport', 'Nome_Report'        , 'varchar(200)          Null', '', ''
	Exec asp_du_AddAlterColumn 'xwpreport', 'Report'             , 'image             Not Null', '', ''
	Exec asp_du_AddAlterColumn 'xwpreport', 'WPDefault_Report'   , 'bit               Not Null', '((0))', ''
	Exec asp_du_AddAlterColumn 'xwpreport', 'Nome_ReportE'       , 'varchar(200)          Null', '('''')', ''
	Exec asp_du_AddAlterColumn 'xwpreport', 'Nome_ReportP'       , 'varchar(200)          Null', '('''')', ''
	Exec asp_du_AddAlterColumn 'xwpreport', 'TimeIns'            , 'smalldatetime     Not Null', '(getdate())', ''
	Exec asp_du_AddAlterColumn 'xwpreport', 'TimeUpd'            , 'smalldatetime     Not Null', '(getdate())', ''
	Exec asp_du_AddAlterColumn 'xwpreport', 'UserIns'            , 'varchar(48)       Not Null', '(host_name())', ''
	Exec asp_du_AddAlterColumn 'xwpreport', 'UserUpd'            , 'varchar(48)       Not Null', '(host_name())', ''
	Exec asp_du_AddAlterColumn 'xwpreport', 'Nome_ReportEP'      , 'varchar(200)          Null', '', ''
	Exec asp_du_AddAlterColumn 'xwpreport', 'RI_EI'              , 'varchar(200)          Null', '', ''
	Exec asp_du_AddAlterColumn 'xwpreport', 'RI_EE'              , 'varchar(200)          Null', '', ''
	Exec asp_du_AddAlterColumn 'xwpreport', 'RI_PI'              , 'varchar(200)          Null', '', ''
	Exec asp_du_AddAlterColumn 'xwpreport', 'RI_PE'              , 'varchar(200)          Null', '', ''
	Exec asp_du_AddAlterColumn 'xwpreport', 'RI_COLLO'           , 'varchar(200)          Null', '', ''
	Exec asp_du_AddAlterColumn 'xwpreport', 'RI_COLLO_QUALITA'   , 'varchar(200)          Null', '', ''
	Exec asp_du_AddAlterColumn 'xwpreport', 'RI_ETICHETTA_PEDANA', 'varchar(200)          Null', '', ''
	Exec asp_du_AddAlterColumn 'xwpreport', 'RI_ETICHETTA_INTERNA', 'varchar(200)          Null', '', ''
	Exec asp_du_AddAlterColumn 'xwpreport', 'RI_PEDANA'          , 'varchar(200)          Null', '', ''

	If dbo.afn_du_isobject('PK_xWPReport') = 0 Alter Table xWPReport   Add
		CONSTRAINT PK_xWPReport PRIMARY KEY NONCLUSTERED(Id_xWPReport)
	If dbo.afn_du_isobject('Uk_xWPReport_Cd_CF') = 0 Alter Table xWPReport   Add
		CONSTRAINT Uk_xWPReport_Cd_CF UNIQUE NONCLUSTERED(Cd_CF)
	If dbo.afn_du_isobject('Uk_xWPReport_cd_WPReport') = 0 Alter Table xWPReport   Add
		CONSTRAINT Uk_xWPReport_cd_WPReport UNIQUE NONCLUSTERED(Cd_WPReport)
	If dbo.afn_du_isobject('FK_XWPReport_CF') = 0 Alter Table xWPReport   Add
		CONSTRAINT FK_XWPReport_CF FOREIGN KEY (Cd_CF) REFERENCES CF (Cd_CF)
	If dbo.afn_du_isobject('CK_xWPReport_Cd_WPReport') = 0 Alter Table xWPReport   Add
		CONSTRAINT CK_xWPReport_Cd_WPReport CHECK ([Cd_WPReport]<>'')
End

----------------------------------------------------------------------------------------
-- Extended Properties (xWPReport)
----------------------------------------------------------------------------------------
Exec asp_du_AddAlterTableComment 'xwpreport', 'Associazione Report - Attività/Fasi - Cliente'

Exec asp_du_AddAlterColumnComment 'xwpreport', 'Cd_CF'              , 'Codice Cliente'
Exec asp_du_AddAlterColumnComment 'xwpreport', 'Cd_WPReport'        , 'Codice'
Exec asp_du_AddAlterColumnComment 'xwpreport', 'Descrizione'        , 'Descrizione'
Exec asp_du_AddAlterColumnComment 'xwpreport', 'Nome_Report'        , 'Interna'
Exec asp_du_AddAlterColumnComment 'xwpreport', 'Report'             , 'Report'
Exec asp_du_AddAlterColumnComment 'xwpreport', 'WPDefault_Report'   , 'Report di Default'
Exec asp_du_AddAlterColumnComment 'xwpreport', 'Nome_ReportE'       , 'Esterna'
Exec asp_du_AddAlterColumnComment 'xwpreport', 'Nome_ReportP'       , 'Pedana'
Exec asp_du_AddAlterColumnComment 'xwpreport', 'Nome_ReportEP'      , 'Etichetta Pedana'

----------------------------------------------------------------------------------------
-- Indici (xWPReport)
----------------------------------------------------------------------------------------
Exec asp_du_AddAlterIndex 'xWPReport', 'IX_xWPReport_Descrizione', 'Descrizione', 0,0,0,0
Exec asp_du_AddAlterIndex 'xWPReport', 'PK_xWPReport', 'Id_xWPReport', 1,0,0,1
Exec asp_du_AddAlterIndex 'xWPReport', 'Uk_xWPReport_Cd_CF', 'Cd_CF', 0,0,1,1
Exec asp_du_AddAlterIndex 'xWPReport', 'Uk_xWPReport_cd_WPReport', 'Cd_WPReport', 0,0,1,1


----------------------------------------------------------------------------------------
-- Triggers (xWPReport)
----------------------------------------------------------------------------------------
If dbo.afn_du_isobject('xWPReport_trg') = 1
     Exec asp_du_DropTrigger 'xWPReport_trg'
");

        DB::statement("

Create Trigger xWPReport_trg On xWPReport For Insert, Update As
Begin
	If (Select Count(*) From Deleted) = 0
		-- Insert
		Update xWPReport Set
		  --DataMov = dbo.afn_Datetime2Date    (Inserted.DataMov),
		  --Sconto	= dbo.afn_PercStrNormalize (Inserted.Sconto ),
			UserIns	= dbo.afn_GetUserInfo(),
			UserUpd	= dbo.afn_GetUserInfo(),
			TimeIns	= Getdate(),
			TimeUpd	= Getdate()
		From xWPReport Join Inserted On xWPReport.Id_xWPReport = Inserted.Id_xWPReport
	Else
		-- Update
		Update xWPReport Set
		  --DataMov = dbo.afn_Datetime2Date    (Inserted.DataMov),
		  --Sconto	= dbo.afn_PercStrNormalize (Inserted.Sconto ),
			UserUpd = dbo.afn_GetUserInfo(),
			TimeUpd = Getdate()
		From xWPReport Join Inserted On xWPReport.Id_xWPReport = Inserted.Id_xWPReport
End
");


    }


    public static function crea_xwpgruppilavoro(){


        // creo la tabella della qualità se manca

        DB::statement("
If	dbo.afn_du_IsTable('xwpGruppiLavoro') = 0 Begin
CREATE TABLE xwpGruppiLavoro (
		Id_xwpGruppiLavoro int Identity(1,1) Not Null,
		UserIns            varchar(48)       Not Null CONSTRAINT DF_xwpGruppiLavoro_UserIns DEFAULT (host_name()),
		UserUpd            varchar(48)       Not Null CONSTRAINT DF_xwpGruppiLavoro_UserUpd DEFAULT (host_name()),
		TimeIns            smalldatetime     Not Null CONSTRAINT DF_xwpGruppiLavoro_TimeIns DEFAULT (getdate()),
		TimeUpd            smalldatetime     Not Null CONSTRAINT DF_xwpGruppiLavoro_TimeUpd DEFAULT (getdate()),
		Ts                 timestamp         Not Null,
		Cd_Operatore       varchar(20)       Not Null,
		Id_PrblAttivita    int               Not Null,
		Id_PrVrAttivita    int                   Null,
		Funzione           varchar(30)       Not Null,
		CONSTRAINT PK_xwpGruppiLavoro PRIMARY KEY NONCLUSTERED(Id_xwpGruppiLavoro)
)
End Else Begin

	Exec asp_du_AddAlterColumn 'xwpgruppilavoro', 'UserIns'           , 'varchar(48)       Not Null', '(host_name())', ''
	Exec asp_du_AddAlterColumn 'xwpgruppilavoro', 'UserUpd'           , 'varchar(48)       Not Null', '(host_name())', ''
	Exec asp_du_AddAlterColumn 'xwpgruppilavoro', 'TimeIns'           , 'smalldatetime     Not Null', '(getdate())', ''
	Exec asp_du_AddAlterColumn 'xwpgruppilavoro', 'TimeUpd'           , 'smalldatetime     Not Null', '(getdate())', ''
	Exec asp_du_AddAlterColumn 'xwpgruppilavoro', 'Cd_Operatore'      , 'varchar(20)       Not Null', '', ''
	Exec asp_du_AddAlterColumn 'xwpgruppilavoro', 'Id_PrblAttivita'   , 'int               Not Null', '', ''
	Exec asp_du_AddAlterColumn 'xwpgruppilavoro', 'Id_PrVrAttivita'   , 'int                   Null', '', ''
	Exec asp_du_AddAlterColumn 'xwpgruppilavoro', 'Funzione'          , 'varchar(30)       Not Null', '', ''

	If dbo.afn_du_isobject('PK_xwpGruppiLavoro') = 0 Alter Table xwpGruppiLavoro   Add
		CONSTRAINT PK_xwpGruppiLavoro PRIMARY KEY NONCLUSTERED(Id_xwpGruppiLavoro)
End

----------------------------------------------------------------------------------------
-- Extended Properties (xwpGruppiLavoro)
----------------------------------------------------------------------------------------
Exec asp_du_AddAlterTableComment 'xwpgruppilavoro', 'Gruppi di Lavoro per Fase'

Exec asp_du_AddAlterColumnComment 'xwpgruppilavoro', 'Cd_Operatore'      , 'Codice Operatore'
Exec asp_du_AddAlterColumnComment 'xwpgruppilavoro', 'Id_PrblAttivita'   , 'Id fase'
Exec asp_du_AddAlterColumnComment 'xwpgruppilavoro', 'Id_PrVrAttivita'   , 'Id versamento'
Exec asp_du_AddAlterColumnComment 'xwpgruppilavoro', 'Funzione'          , 'R=Resp. C=CapoReparto A= Assistente'

----------------------------------------------------------------------------------------
-- Indici (xwpGruppiLavoro)
----------------------------------------------------------------------------------------
Exec asp_du_AddAlterIndex 'xwpGruppiLavoro', 'Ix_xwpgruppilavoro_id_prblattivita', 'Id_PrblAttivita', 0,0,0,0
Exec asp_du_AddAlterIndex 'xwpGruppiLavoro', 'PK_xwpGruppiLavoro', 'Id_xwpGruppiLavoro', 1,0,0,1


----------------------------------------------------------------------------------------
-- Triggers (xwpGruppiLavoro)
----------------------------------------------------------------------------------------
If dbo.afn_du_isobject('xwpGruppiLavoro_trg') = 1
     Exec asp_du_DropTrigger 'xwpGruppiLavoro_trg'
");
        DB::statement("
Create Trigger xwpGruppiLavoro_trg On xwpGruppiLavoro For Insert, Update As
Begin
	If (Select Count(*) From Deleted) = 0
		-- Insert
		Update xwpGruppiLavoro Set
		  --DataMov = dbo.afn_Datetime2Date    (Inserted.DataMov),
		  --Sconto	= dbo.afn_PercStrNormalize (Inserted.Sconto ),
			UserIns	= dbo.afn_GetUserInfo(),
			UserUpd	= dbo.afn_GetUserInfo(),
			TimeIns	= Getdate(),
			TimeUpd	= Getdate()
		From xwpGruppiLavoro Join Inserted On xwpGruppiLavoro.Id_xwpGruppiLavoro = Inserted.Id_xwpGruppiLavoro
	Else
		-- Update
		Update xwpGruppiLavoro Set
		  --DataMov = dbo.afn_Datetime2Date    (Inserted.DataMov),
		  --Sconto	= dbo.afn_PercStrNormalize (Inserted.Sconto ),
			UserUpd = dbo.afn_GetUserInfo(),
			TimeUpd = Getdate()
		From xwpGruppiLavoro Join Inserted On xwpGruppiLavoro.Id_xwpGruppiLavoro = Inserted.Id_xwpGruppiLavoro
End

");

    }
}

<?php

namespace App\Http\Controllers\Reports\Sale;

use Illuminate\Http\Request;

class ClearanceInvoiceReportController extends PendingInvoiceReportController
{
    public function index()
    {
        return view('Reports.Sale.pending_invoice_report.index', [
            'reportTitle' => 'Clearance Invoice Report',
            'reportSlug' => 'clearance_invoice_report',
            'dataUrl' => url('reports/sale/get_clearance_invoice_report'),
            'emptyMessage' => 'No fully paid invoices found for the selected filters.',
        ]);
    }

    public function get_data(Request $request)
    {
        $request->merge(['clearance' => true]);

        return parent::get_data($request);
    }
}

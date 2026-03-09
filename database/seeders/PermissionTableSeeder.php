<?php
  
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $permissions = [
//           'Dashboard',
//            'Lms',
//        ];
//
//        foreach ($permissions as $permission) {
//             $ret=Permission::create(['name' => $permission, 'form'=>0, 'menu'=>1]);
//            $fixstr=str_replace(' ', '_', strtolower($permission));
//            Permission::create(['name' => $fixstr.'_view', 'parent_id'=>$ret->id]);
//        }
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'0', 'name' => 'Dashboard', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'1', 'name' => 'dashboard_view', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'0', 'name' => 'Lms', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'3', 'name' => 'lms_view', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'0', 'name' => 'My Leads', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'5', 'name' => 'my_leads_view', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'0', 'name' => 'All Leads', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'7', 'name' => 'all_leads_view', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'0', 'name' => 'Lead Ticket', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'9', 'name' => 'lead_ticket_view', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 1, 'menu' => 1, 'parent_id' =>'0', 'name' => 'Lead', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'11', 'name' => 'lead_view', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'11', 'name' => 'lead_create', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'11', 'name' => 'lead_edit', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'11', 'name' => 'lead_delete', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'11', 'name' => 'lead_approve', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'11', 'name' => 'lead_send', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'11', 'name' => 'lead_upload', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'0', 'name' => 'Lead Hotel', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'19', 'name' => 'lead_hotel_view', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'0', 'name' => 'Lead Visa', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'21', 'name' => 'lead_visa_view', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'0', 'name' => 'Lead Transport', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'23', 'name' => 'lead_transport_view', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'0', 'name' => 'Lead Tour', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'25', 'name' => 'lead_tour_view', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'0', 'name' => 'Lead Other', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'27', 'name' => 'lead_other_view', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'', 'name' => 'Pending Leads', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'29', 'name' => 'pending_leads_view', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'', 'name' => 'Sale Invoices', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'31', 'name' => 'sale_invoices_view', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 1, 'menu' => 1, 'parent_id' =>'', 'name' => 'Sale Ticket', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'33', 'name' => 'sale_ticket_view', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'33', 'name' => 'sale_ticket_create', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'33', 'name' => 'sale_ticket_edit', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'33', 'name' => 'sale_ticket_delete', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'33', 'name' => 'sale_ticket_approve', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'33', 'name' => 'sale_ticket_send', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'33', 'name' => 'sale_ticket_upload', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 1, 'menu' => 1, 'parent_id' =>'', 'name' => 'Sale Hotel', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'41', 'name' => 'sale_hotel_view', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'41', 'name' => 'sale_hotel_create', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'41', 'name' => 'sale_hotel_edit', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'41', 'name' => 'sale_hotel_delete', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'41', 'name' => 'sale_hotel_approve', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'41', 'name' => 'sale_hotel_send', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'41', 'name' => 'sale_hotel_upload', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 1, 'menu' => 1, 'parent_id' =>'', 'name' => 'Sale Visa', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'49', 'name' => 'sale_visa_view', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'49', 'name' => 'sale_visa_create', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'49', 'name' => 'sale_visa_edit', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'49', 'name' => 'sale_visa_delete', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'49', 'name' => 'sale_visa_approve', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'49', 'name' => 'sale_visa_send', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'49', 'name' => 'sale_visa_upload', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 1, 'menu' => 1, 'parent_id' =>'', 'name' => 'Sale Transport', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'57', 'name' => 'sale_transport_view', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'57', 'name' => 'sale_transport_create', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'57', 'name' => 'sale_transport_edit', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'57', 'name' => 'sale_transport_delete', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'57', 'name' => 'sale_transport_approve', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'57', 'name' => 'sale_transport_send', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'57', 'name' => 'sale_transport_upload', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 1, 'menu' => 1, 'parent_id' =>'', 'name' => 'Sale Tour', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'65', 'name' => 'sale_tour_view', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'65', 'name' => 'sale_tour_create', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'65', 'name' => 'sale_tour_edit', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'65', 'name' => 'sale_tour_delete', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'65', 'name' => 'sale_tour_approve', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'65', 'name' => 'sale_tour_send', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'65', 'name' => 'sale_tour_upload', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 1, 'menu' => 1, 'parent_id' =>'', 'name' => 'Sale Other', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'73', 'name' => 'sale_other_view', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'73', 'name' => 'sale_other_create', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'73', 'name' => 'sale_other_edit', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'73', 'name' => 'sale_other_delete', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'73', 'name' => 'sale_other_approve', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'73', 'name' => 'sale_other_send', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);
        Permission::create([ 'form' => 0, 'menu' => 1, 'parent_id' =>'73', 'name' => 'sale_other_upload', 'guard_name' => 'web', 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now() ]);

    }
}
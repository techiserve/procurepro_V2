<?php
namespace App\Http\Controllers;
use App\Models\FormField;
use App\Models\Frequisition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class RequisitionController extends Controller
{
    public function configureForm()
    {
        return view('configure-form');
    }

    public function storeFormConfiguration(Request $request)
    {
        $fields = $request->input('fields');

        foreach ($fields as $field) {
            // Save form field configuration
            FormField::create([
                'name' => $field['name'],
                'label' => $field['label'],
                'type' => $field['type'],
            ]);

            // Dynamically add column to requisitions table
            if (!Schema::hasColumn('drequisitions', $field['name'])) {
                Schema::table('drequisitions', function (Blueprint $table) use ($field) {
                    switch ($field['type']) {
                        case 'string':
                            $table->string($field['name'])->nullable();
                            break;
                        case 'integer':
                            $table->integer($field['name'])->nullable();
                            break;
                        case 'text':
                            $table->text($field['name'])->nullable();
                            break;
                        // Add more cases as needed
                        default:
                            $table->string($field['name'])->nullable();
                    }
                });
            }
        }

        return redirect()->route('requisition.create');
    }

    public function createRequisition()
    {
        $formFields = FormField::all();
        return view('create-requisition', compact('formFields'));
    }

    public function storeRequisition(Request $request)
    {
        $formFields = FormField::all();
        $data = [];

        foreach ($formFields as $field) {
            $data[$field->name] = $request->input($field->name);
        }

        Frequisition::create($data);

        return redirect()->back()->with('success', 'Requisition submitted successfully.');
    }
}

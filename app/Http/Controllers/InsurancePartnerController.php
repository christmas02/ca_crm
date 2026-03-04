<?php

namespace App\Http\Controllers;

use App\Models\InsurancePartner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InsurancePartnerController extends Controller
{

    public function index()
    {
        $this->authorize('viewAny', InsurancePartner::class);
        $partners = InsurancePartner::latest()->paginate(15);
        return view('insurance_partners.index', compact('partners'));
    }

    public function create()
    {
        $this->authorize('create', InsurancePartner::class);
        return view('insurance_partners.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', InsurancePartner::class);
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:insurance_partners',
                'email' => 'required|email|unique:insurance_partners',
                'telephone' => 'nullable|string|max:20',
                'website' => 'nullable|url',
                'description' => 'nullable|string',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
                'commission_rate' => 'required|numeric|min:0|max:100',
                'active' => 'nullable|boolean',
            ]);

            if ($request->hasFile('logo')) {
                $validated['logo'] = $request->file('logo')->store('logos', 'public');
            }

            $validated['active'] = $request->boolean('active', true);

            InsurancePartner::create($validated);

            return redirect()->route('insurance-partners.index')
                ->with('success', 'Partenaire d\'assurance créé avec succès.');
        } catch (\Exception $e) {
            return redirect()->route('insurance-partners.create')
                ->withInput($request->all())
                ->with('error', 'Erreur lors de la création: ' . $e->getMessage());
        }
    }

    public function show(InsurancePartner $insurancePartner)
    {
        $this->authorize('view', $insurancePartner);
        return view('insurance_partners.show', compact('insurancePartner'));
    }

    public function edit(InsurancePartner $insurancePartner)
    {
        $this->authorize('update', $insurancePartner);
        return view('insurance_partners.edit', compact('insurancePartner'));
    }

    public function update(Request $request, InsurancePartner $insurancePartner)
    {
        $this->authorize('update', $insurancePartner);
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:insurance_partners,name,' . $insurancePartner->id,
                'email' => 'required|email|unique:insurance_partners,email,' . $insurancePartner->id,
                'telephone' => 'nullable|string|max:20',
                'website' => 'nullable|url',
                'description' => 'nullable|string',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
                'commission_rate' => 'required|numeric|min:0|max:100',
                'active' => 'nullable|boolean',
            ]);

            if ($request->hasFile('logo')) {
                if ($insurancePartner->logo) {
                    Storage::disk('public')->delete($insurancePartner->logo);
                }
                $validated['logo'] = $request->file('logo')->store('logos', 'public');
            }

            $validated['active'] = $request->boolean('active', true);

            $insurancePartner->update($validated);

            return redirect()->route('insurance-partners.show', $insurancePartner)
                ->with('success', 'Partenaire d\'assurance mis à jour avec succès.');
        } catch (\Exception $e) {
            return redirect()->route('insurance-partners.edit', $insurancePartner)
                ->withInput($request->all())
                ->with('error', 'Erreur lors de la mise à jour: ' . $e->getMessage());
        }
    }

    public function destroy(InsurancePartner $insurancePartner)
    {
        $this->authorize('delete', $insurancePartner);
        try {
            if ($insurancePartner->logo) {
                Storage::disk('public')->delete($insurancePartner->logo);
            }

            $insurancePartner->delete();

            return redirect()->route('insurance-partners.index')
                ->with('success', 'Partenaire d\'assurance supprimé avec succès.');
        } catch (\Exception $e) {
            return redirect()->route('insurance-partners.index')
                ->with('error', 'Erreur lors de la suppression: ' . $e->getMessage());
        }
    }
}

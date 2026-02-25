<?php

namespace LaraGrape\Http\Controllers;

use LaraGrape\Models\Form;
use LaraGrape\Services\FormService;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function __construct(
        protected FormService $formService
    ) {}

    public function submit(Request $request, Form $form)
    {
        if (! $form->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'This form is not active.',
            ], 400);
        }

        $result = $this->formService->submitForm($form, $request);

        if ($request->expectsJson()) {
            return response()->json($result);
        }

        if ($result['success']) {
            return back()->with('success', $result['message']);
        }

        return back()->withErrors($result['errors'])->withInput();
    }

    public function preview(Form $form)
    {
        if (! $form->is_active) {
            abort(404);
        }

        $formHtml = $this->formService->generateFormHtml($form);

        $viewName = 'LaraGrape::forms.preview';
        if (! view()->exists($viewName)) {
            $viewName = 'forms.preview';
        }

        return view($viewName, compact('form', 'formHtml'));
    }

    public function embed(Form $form)
    {
        if (! $form->is_active) {
            abort(404);
        }

        $formHtml = $this->formService->generateFormHtml($form);

        return response($formHtml)->header('Content-Type', 'text/html');
    }
}

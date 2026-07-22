<?php

namespace App\Http\Controllers;

use App\Models\Trade;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    public function index(Request $request)
    {
        $trades = $request->user()->trades()->latest("entry_date")->paginate(15);

        $stats = [
            "total_trades" => $request->user()->trades()->count(),
            "wins" => $request->user()->trades()->where("pnl", ">", 0)->count(),
            "losses" => $request->user()->trades()->where("pnl", "<", 0)->count(),
            "net_pnl" => $request->user()->trades()->sum("pnl"),
        ];

        return view("journal.index", compact("trades", "stats"));
    }

    public function create()
    {
        return view("journal.create");
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);
        $validated["pnl"] = $this->calculatePnl($validated);

        $request->user()->trades()->create($validated);

        return redirect()->route("journal.index")->with("status", "Trade logged.");
    }

    public function edit(Trade $trade)
    {
        $this->authorizeOwner($trade);

        return view("journal.edit", compact("trade"));
    }

    public function update(Request $request, Trade $trade)
    {
        $this->authorizeOwner($trade);

        $validated = $this->validated($request);
        $validated["pnl"] = $this->calculatePnl($validated);

        $trade->update($validated);

        return redirect()->route("journal.index")->with("status", "Trade updated.");
    }

    public function destroy(Trade $trade)
    {
        $this->authorizeOwner($trade);
        $trade->delete();

        return back()->with("status", "Trade deleted.");
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            "symbol" => ["required", "string", "max:20"],
            "direction" => ["required", "in:long,short"],
            "entry_price" => ["required", "numeric"],
            "exit_price" => ["nullable", "numeric"],
            "quantity" => ["required", "numeric"],
            "entry_date" => ["required", "date"],
            "exit_date" => ["nullable", "date"],
            "setup" => ["nullable", "string", "max:255"],
            "notes" => ["nullable", "string", "max:5000"],
        ]);
    }

    private function calculatePnl(array $data): ?float
    {
        if (empty($data["exit_price"])) {
            return null;
        }

        $diff = $data["direction"] === "long"
            ? $data["exit_price"] - $data["entry_price"]
            : $data["entry_price"] - $data["exit_price"];

        return round($diff * $data["quantity"], 4);
    }

    private function authorizeOwner(Trade $trade): void
    {
        abort_unless($trade->user_id === request()->user()->id, 403);
    }
}

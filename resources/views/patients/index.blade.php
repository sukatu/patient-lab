<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Patient Directory · Odin Patient Lab</title>
    <style>
        :root { color-scheme: light; --ink:#172033; --muted:#657086; --line:#dfe5ee; --brand:#3c5cff; --soft:#f4f7fb; --success:#147a4b; --danger:#a54040; }
        * { box-sizing: border-box; }
        body { margin:0; background:#f6f8fc; color:var(--ink); font:15px/1.5 ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif; }
        header { background:#111a2e; color:white; }
        .bar,.page { width:min(1120px,calc(100% - 32px)); margin:auto; }
        .bar { min-height:72px; display:flex; align-items:center; justify-content:space-between; gap:24px; }
        .brand { font-size:20px; font-weight:750; letter-spacing:-.02em; }
        .env { color:#bbc6db; font-size:13px; }
        main { padding:46px 0 64px; }
        h1 { margin:0; font-size:clamp(30px,5vw,48px); letter-spacing:-.04em; line-height:1.05; }
        .lede { max-width:680px; color:var(--muted); font-size:17px; margin:12px 0 30px; }
        .panel { background:white; border:1px solid var(--line); border-radius:18px; box-shadow:0 14px 40px rgba(35,48,82,.08); overflow:hidden; }
        form { display:grid; grid-template-columns:1fr 170px auto; gap:12px; padding:20px; border-bottom:1px solid var(--line); }
        input,select,button { min-height:46px; border-radius:10px; font:inherit; }
        input,select { width:100%; border:1px solid #cdd5e2; padding:0 14px; color:var(--ink); background:white; }
        input:focus,select:focus { outline:3px solid rgba(60,92,255,.18); border-color:var(--brand); }
        button { border:0; background:var(--brand); color:white; padding:0 22px; font-weight:700; cursor:pointer; }
        button:hover { background:#2947df; }
        .summary { display:flex; align-items:center; justify-content:space-between; gap:16px; padding:18px 20px; }
        .actions { display:flex; align-items:center; gap:14px; }
        .summary strong { font-size:17px; }
        .clear { color:var(--brand); font-weight:650; text-decoration:none; }
        .export { display:inline-flex; align-items:center; min-height:38px; padding:0 14px; border:1px solid #cbd4e4; border-radius:9px; color:#293a5d; background:white; font-weight:700; text-decoration:none; }
        .export:hover { border-color:var(--brand); color:var(--brand); }
        .table-wrap { overflow-x:auto; }
        table { width:100%; border-collapse:collapse; }
        th,td { padding:15px 20px; text-align:left; border-top:1px solid var(--line); white-space:nowrap; }
        th { color:var(--muted); background:#fbfcfe; font-size:12px; text-transform:uppercase; letter-spacing:.08em; }
        td:first-child { font-weight:750; color:#33435f; }
        .name { font-weight:750; }
        .sub { color:var(--muted); font-size:13px; }
        .badge { display:inline-flex; align-items:center; border-radius:999px; padding:4px 9px; font-size:12px; font-weight:750; text-transform:capitalize; }
        .badge.active { color:var(--success); background:#e8f7ef; }
        .badge.inactive { color:var(--danger); background:#fbecec; }
        .empty { padding:64px 24px; text-align:center; border-top:1px solid var(--line); }
        .empty .icon { width:54px; height:54px; display:grid; place-items:center; margin:0 auto 14px; border-radius:16px; background:var(--soft); font-size:25px; }
        .empty h2 { margin:0 0 6px; }
        .empty p { margin:0; color:var(--muted); }
        nav { display:flex; justify-content:space-between; align-items:center; padding:18px 20px; border-top:1px solid var(--line); }
        nav a { text-decoration:none; color:var(--brand); font-weight:700; }
        nav span { color:var(--muted); }
        @media (max-width:720px) { form { grid-template-columns:1fr; } .bar { align-items:flex-start; flex-direction:column; justify-content:center; gap:2px; } th,td { padding:13px 14px; } }
    </style>
</head>
<body>
<header>
    <div class="bar">
        <div class="brand">Odin Patient Lab</div>
        <div class="env">Fictional training data · Local environment</div>
    </div>
</header>
<main class="page">
    <h1>Patient directory</h1>
    <p class="lede">Search fictional patient records by name, patient number, email, or phone. Use this sandbox to practise UI, database, testing, and accessibility tasks.</p>

    <section class="panel" aria-labelledby="results-title">
        <form action="{{ route('patients.index') }}" method="get" role="search">
            <label>
                <span class="sub">Search patients</span>
                <input name="q" value="{{ $term }}" placeholder="Try Ama or PAT-10001" autocomplete="off">
            </label>
            <label>
                <span class="sub">Status</span>
                <select name="status">
                    <option value="all" @selected($status === 'all')>All statuses</option>
                    <option value="active" @selected($status === 'active')>Active</option>
                    <option value="inactive" @selected($status === 'inactive')>Inactive</option>
                </select>
            </label>
            <button type="submit">Search</button>
        </form>

        <div class="summary">
            <strong id="results-title">{{ $patients->total() }} {{ Str::plural('patient', $patients->total()) }} found</strong>
            <div class="actions">
                @if ($term !== '' || $status !== 'all')
                    <a class="clear" href="{{ route('patients.index') }}">Clear filters</a>
                @endif
                <a class="export" href="{{ route('patients.export', ['q' => $term, 'status' => $status]) }}">Export CSV</a>
            </div>
        </div>

        @if ($patients->count())
            <div class="table-wrap">
                <table>
                    <thead><tr><th>Patient ID</th><th>Patient</th><th>Date of birth</th><th>Location</th><th>Last visit</th><th>Status</th></tr></thead>
                    <tbody>
                    @foreach ($patients as $patient)
                        <tr>
                            <td>{{ $patient->patient_number }}</td>
                            <td><div class="name">{{ $patient->first_name }} {{ $patient->last_name }}</div><div class="sub">{{ $patient->email }}</div></td>
                            <td>{{ $patient->date_of_birth->format('d M Y') }}<div class="sub">{{ $patient->sex }}</div></td>
                            <td>{{ $patient->city ?: '—' }}</td>
                            <td>{{ $patient->last_visit_at?->format('d M Y') ?? 'No visit recorded' }}</td>
                            <td><span class="badge {{ $patient->status }}">{{ $patient->status }}</span></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @if ($patients->hasPages())
                <nav aria-label="Patient results pagination">
                    @if ($patients->onFirstPage()) <span>← Previous</span> @else <a href="{{ $patients->previousPageUrl() }}">← Previous</a> @endif
                    <span>Page {{ $patients->currentPage() }} of {{ $patients->lastPage() }}</span>
                    @if ($patients->hasMorePages()) <a href="{{ $patients->nextPageUrl() }}">Next →</a> @else <span>Next →</span> @endif
                </nav>
            @endif
        @else
            <div class="empty" role="status">
                <div class="icon" aria-hidden="true">⌕</div>
                <h2>No patients matched</h2>
                <p>Try a different name, patient number, email, phone, or status.</p>
            </div>
        @endif
    </section>
</main>
</body>
</html>

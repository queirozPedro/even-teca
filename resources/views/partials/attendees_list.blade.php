
<div style="min-width:320px; max-width:90vw; max-height:90vh; overflow-y:auto;">
    @if($attendees->isEmpty())
        <div style="text-align:center; color:#64748b; font-size:1.1rem; padding:2rem 0;">Nenhum participante inscrito neste evento.</div>
    @else
        <ul style="list-style:none; padding:0; margin:0;">
            @foreach($attendees as $registration)
                <li style="padding:0.7rem 0; border-bottom:1px solid #e5e7eb; display:flex; align-items:center; gap:1rem;">
                    <i class="fa-solid fa-user" style="color:#2563eb;"></i>
                    <span style="font-weight:500; color:#334155;">{{ $registration->user->name }}</span>
                    <span style="color:#64748b; font-size:0.95rem;">({{ $registration->user->email }})</span>
                    <span style="margin-left:auto; color:#22c55e; font-size:0.95rem;">
                        {{ ucfirst($registration->status) }}
                    </span>
                </li>
            @endforeach
        </ul>
    @endif
</div>

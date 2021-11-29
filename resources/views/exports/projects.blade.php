@foreach($projects as $project)
    <table>
        <thead>
        <tr>
            <th><b>Project Name</b></th>
            <th><b>Description</b></th>
        </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $project->title }}</td>
                <td>{{ $project->description }}</td>
            </tr>
        </tbody>
    </table>
    <table>
        <thead>
        <tr>
            <th><b>Task#</b></th>
            <th><b>Task Summary</b></th>
            <th><b>Description</b></th>
            <th><b>Points</b></th>
            <th><b>Status</b></th>
            <th><b>Start Date</b></th>
            <th><b>End Date</b></th>
            <th><b>Assigned To</b></th>
            <th><b>Created By</b></th>
            <th><b>Updated By</b></th>
            <th><b>Created At</b></th>
            <th><b>Updated At</b></th>
        </tr>
        </thead>
        <tbody>
            @foreach($project->tasks as $task)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $task->title }}</td>
                    <td>{{ $task->description }}</td>
                    <td>{{ $task->points }}</td>
                    <td style="color:{!! $task->completed=='1'?'green':'red' !!};">{!! $task->completed=='1'?'Completed':'Incomplete' !!}</td>
                    <td>{{ \Carbon\Carbon::parse($task->start_date)->format('d-M-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($task->end_date)->format('d-M-Y') }}</td>
                    <td>
                        @foreach($task->members as $member)
                            {!! $loop->iteration>1?', ':'' !!}
                            {{ $member->user->username }}
                        @endforeach
                    </td>
                    <td>{{ $task->creator->username }}</td>
                    <td>{{ $task->updated_by != '' ? $task->updater->username : 'None' }}</td>
                    <td>{{ \Carbon\Carbon::parse($task->created_at)->format('d-M-Y') }}</td>
                    <td>{{ !empty($task->updated_at)?\Carbon\Carbon::parse($task->updated_at)->format('d-M-Y'):'Never' }}</td>
                </tr>
            @endforeach
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
@endforeach

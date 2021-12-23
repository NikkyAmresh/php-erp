tables - head - th 1 - th 1 - tbody - tr - td1 - td2 - tr2...

$arrayOfObj -> [{id,name,code},{id,name,code},{id,name,code},{id,name,code}]
$arrayOfHeadings -> ['serial no','Name','Code','Edit']
$type = ""

<table>
    <thead>
        for heading in arrayOfHeadings
            <th>heading</th>
        endFor
    </thead>
    <tbody>
        for obj in $arrayOfObj:
            <tr>
                for data in obj:
                    <td>data</td>
                endFor
                    <td>Edit.id /Delete</td>
            </tr>
        endFor
    </tbody>
</table>

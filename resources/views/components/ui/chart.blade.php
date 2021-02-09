<div class="chart" id="wrapper-chart--{{$id}}">
    <canvas id="{{ $id }}" class="chart-canvas"></canvas>
</div>

@push('js')
<script>
    chartsToRender.push(
        {
            canvasSelector: "#{{ $id }}",
            type: "{{$type}}",
            dataset: @json($chartData)
        }
    );

</script>
@endpush

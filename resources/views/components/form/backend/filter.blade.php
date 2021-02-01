
@foreach ($allowedFilters as $filter => $filterConfig)
                                        <div class="col-3">
                                            @switch (Arr::get($filterConfig, 'type', 'input'))
                                                @case('select')
                                                    <x-form.select :name="'filter['. $filter . ']'" :title="__(Arr::get($filterConfig, 'title', $filter))" :options="Arr::get($filterConfig, 'options', [])" :selected="Arr::get($searchedParams, $filter)" required :hide-label="true">
                                                    </x-form.select>
                                                    @break

                                                @default
                                                    <x-form.input :name="'filter['. $filter . ']'" :title="__(Arr::get($filterConfig, 'title', $filter))" hideLabel="true" :value="Arr::get($searchedParams, $filter)" />
                                            @endswitch
                                        </div>
                                        @endforeach

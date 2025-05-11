@props(['tipPercentage' => 12])

<div class="bg-[#FFF9E5] p-4 rounded-lg">
    <div class="flex justify-between items-center mb-2">
        <div class="text-sm">
            <p class="text-gray-700">Add a tip to support Night Bright</p>
            <p class="text-gray-500 mt-1">Night Bright does not charge any platform fees and relies on your generosity to support this free service.</p>
        </div>
    </div>
    <select
        name="tip_percentage"
        class="mt-2 w-full rounded-md border-gray-300 focus:border-[#C49052] focus:ring-[#C49052]">
        <option value="0" @selected($tipPercentage === 0)>No Tip</option>
        <option value="12" @selected($tipPercentage === 12)>12% (Recommended)</option>
        <option value="15" @selected($tipPercentage === 15)>15%</option>
        <option value="20" @selected($tipPercentage === 20)>20%</option>
    </select>
</div>

<div class="container mx-auto p-4 bg-gray-200 dark:bg-gray-800">
    <!-- This example requires Tailwind CSS v2.0+ -->
<div class="flex items-center justify-end px-4 py-3 text-right sm:px-6">
        <x-jet-button wire:click="createShowModal" class="bg-green-600 font-bold hover:bg-green-800">
            {{ __('Create') }}
        </x-jet-button>
    </div>
    <div class="flex flex-col">
  <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
      <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50 dark:bg-gray-600 dark:text-gray-200">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                Id
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                Title
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                Status
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-200 uppercase tracking-wider">
                Featured
              </th>
              <th scope="col" class="relative px-6 py-3">
                Edit
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr>
                @foreach ($posts as $post)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $post->id }}
              </td>
               <td class="px-6 py-4 whitespace-nowrap">
                        {{ $post->title }}
              </td>
               <td class="px-6 py-4 whitespace-nowrap">
                        {{ $post->active }}
              </td>
               <td class="px-6 py-4 whitespace-nowrap">
                        <img class="w-8 h-8 rounded-full" src="{{ asset('storage/photos/'. $post->image) }}">
              </td>
               <td class="px-6 py-4 text-right text-sm">
                      <x-jet-button wire:click="updateShowModal({{ $post->id }})"  class="bg-green-600 font-bold hover:bg-green-800">
                          {{ __('Update') }}
                      </x-jet-button>
                      <x-jet-danger-button wire:click="deletePost({{ $post->id }})">
                          {{ __('Delete') }}
                      </x-jet-button>
                  </td>
                </tr>
                @endforeach
            <!-- More items... -->
          </tbody>
        </table>
       <div class="m-2 p-2">
        {{ $posts->links()}}
       </div>
    </div>
    </div>
  </div>
</div>
{{-- Modal Form --}}
    <x-jet-dialog-modal wire:model="modalFormVisible">
        <x-slot name="title">
            {{ __('Save Post') }}
        </x-slot>

        <x-slot name="content">
        <div class="space-y-8 divide-y divide-gray-200 w-1/2 mt-10">

            <form enctype="multipart/form-data">
            <div class="sm:col-span-6">
                <label for="title" class="block text-sm font-medium text-gray-700">
                    Post Title
                </label>
                <div class="mt-1">
                    <input type="text" id="title" wire:model="title" name="title" class="block w-full transition duration-150 ease-in-out appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                </div>
                    @error('title') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
            </div>
            <div class="sm:col-span-6">
                <div class="w-full m-4 p-4">
                  @if($modelId)
                  <div class="m-2">
                    <img class="w-44 h-44 object-cover rounded-lg" src="{{ asset('storage/photos/'. $image) }}">
                  </div>
                  @endif
                    @if($newImage)
                  <div class="m-2">
                    <img class="w-44 h-44 object-cover rounded-lg" src="{{ $newImage->temporaryUrl() }}">
                  </div>
                    @endif
                </div>
                <label for="title" class="block text-sm font-medium text-gray-700">
                    Post Image
                </label>
                <div class="mt-1">
                    <input type="file" id="image" wire:model="newImage" name="image" class="block w-full transition duration-150 ease-in-out appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                </div>
                    @error('newImage') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
            </div>
            <div class="sm:col-span-6 pt-5">
                <label for="body" class="block text-sm font-medium text-gray-700">Body</label>
                <div class="mt-1">
                    <textarea id="body" rows="3" wire:model="body" class="shadow-sm focus:ring-indigo-500 appearance-none bg-white border border-gray-400 rounded-md py-2 px-3 text-base leading-normal transition duration-150 ease-in-out focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"></textarea>
                </div>
                    @error('body') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
            </div>
            </form>
         </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('modalFormVisible')" wire:loading.attr="disabled">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            @if ($modelId)
                <x-jet-button class="ml-2" wire:click="update" wire:loading.attr="disabled">
                    {{ __('Update') }}
                </x-jet-danger-button>
            @else
                <x-jet-button class="ml-2" wire:click="savePost" wire:loading.attr="disabled">
                    {{ __('Create') }}
                </x-jet-danger-button>
            @endif
            
        </x-slot>
    </x-jet-dialog-modal>
</div>

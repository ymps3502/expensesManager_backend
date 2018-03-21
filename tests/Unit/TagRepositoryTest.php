<?php

use Tests\TestCase;
use Tests\Unit\SeedData;
use App\Repositories\TagRepository;

class TagRepositoryTest extends TestCase
{
    use SeedData;
    protected $repository = null;

    protected function setUp()
    {
        parent::setUp();

        $this->initDatabase();
        $this->seedData("thisWeek");
        
        $this->repository = new TagRepository();
    }

    protected function tearDown()
    {
        $this->resetDatabase();
        $this->repositroy = null;
    }

    /**
     * @group TagRepository
     * @group Tag
     */
    public function testCreateTag()
    {
        $nextId = App\Tag::latest('id')->first()->id + 1;
        $tag = $this->repository->createTag(['name' => 'test']);

        $this->assertEquals($nextId, $tag->id);
    }

    /**
     * @group TagRepository
     * @group Subtag
     */
    public function testCreateSubtag()
    {
        $latestSubtag = App\Subtag::latest('id')->first();
        $tagId = $latestSubtag->tag->id;
        $nextId = $latestSubtag->id + 1;
        $subtag = $this->repository->createSubtag(['name' => 'test', 'tag_id' => $tagId]);

        $this->assertEquals($nextId, $subtag->id);
        $this->assertEquals($tagId, $subtag->tag_id);
    }

    /**
     * @group TagRepository
     * @group Tag
     */
    public function testUpdateTag()
    {
        $newData = ['name' => 'new test'];
        $randomId = rand(1, App\Tag::count());
        sleep(1);
        $this->repository->updateTag($randomId, $newData);
        $newTag = App\Tag::find($randomId);

        $this->assertNotEquals($newTag->created_at, $newTag->updated_at);
        $this->assertEquals($newTag->name, $newData['name']);
    }

    /**
     * @group TagRepository
     * @group Subtag
     */
    public function testUpdateSubtag()
    {
        $newData = ['name' => 'new test'];
        $randomId = rand(1, App\Subtag::count());
        sleep(1);
        $this->repository->updateSubtag($randomId, $newData);
        $newTag = App\Subtag::find($randomId);

        $this->assertNotEquals($newTag->created_at, $newTag->updated_at);
        $this->assertEquals($newTag->name, $newData['name']);
    }

    /**
     * @group TagRepository
     * @group Tag
     */
    public function testDeleteTag()
    {
        $randomId = rand(1, App\Tag::count());
        $total = App\Tag::count();
        $this->repository->deleteTag($randomId);
        $this->assertEquals(App\Tag::count(), $total - 1);
    }

    /**
     * @group TagRepository
     * @group Subtag
     */
    public function testDeleteSubtag()
    {
        $randomId = rand(1, App\Subtag::count());
        $total = App\Subtag::count();
        $this->repository->deleteSubtag($randomId);
        $this->assertEquals(App\Subtag::count(), $total - 1);
    }
}
<?php

namespace App\Http\Controllers\admin\posts;         

use App\Http\Controllers\Controller;                     
use App\Http\Requests\Admin\Post\PostRequest;   
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $search = $request->input('search');
            if ($search) {
                $posts = Post::where('title', 'like', '%' . $search . '%')->get();
            } else {
                $posts = Post::with(['author', 'category'])->get();
            }
            return response()->json([
                'success' => true,
                'data' => $posts,
                'message' => 'Danh sách bài viết đã được tải thành công!'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
               'success' => false,
                'message' => 'Đã xảy ra lỗi trong quá trình tải danh sách!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        try {
            // Dữ liệu đã được xác thực và hợp lệ
            // Tạo bài viết mới
            $post = Post::create($request->validated());
            return response()->json([
                'success' => true,
                'data' => $post,
                'message' => 'Bài viết đã được tạo thành công!'
            ], 201);
        } catch (ValidationException $e) {
            // Xử lý lỗi validation nếu có
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu nhập không hợp lệ',
                'errors' => $e->errors() // Lấy thông báo lỗi từ ngoại lệ
            ], 422);
        } catch (\Exception $e) {
            // Xử lý các lỗi khác nếu có
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi không mong muốn',
                'error' => $e->getMessage()
            ], 500); // HTTP Status 500: Internal Server Error
        }
    }


    /**
     * Display the specified resource.
     */
    public
    function show(string $id)
    {
        try {
            $post = Post::with(['author', 'category', 'comments'])->findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $post,
                'message' => 'Bài viết đã được tải thành công!'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy bài viết.',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public
    function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public
    function update(Request $request, string $id)
    {
        try {
            // Tìm bài viết theo ID hoặc trả về lỗi 404 nếu không tìm thấy
            $post = Post::findOrFail($id);
            // Lấy dữ liệu từ yêu cầu, chỉ lấy các trường có trong $fillable của model
            $data = $request->only($post->getFillable());
            // Cập nhật bài viết với dữ liệu từ yêu cầu, chỉ cập nhật các trường thay đổi
            $post->fill($data);
            if ($post->isDirty()) {
                $post->save();
                // Trả về phản hồi JSON với dữ liệu đã cập nhật và thông báo thành công
                return response()->json([
                    'success' => true,
                    'data' => $post,
                    'message' => 'Bài viết đã được cập nhật thành công!'
                ], 200); // HTTP Status 200: OK
            } else {
                return response()->json([
                    'success' => true,
                    'message' => 'Không có thay đổi nào được thực hiện.'
                ], 200); // HTTP Status 200: OK
            }
        } catch (ValidationException $e) {
            // Xử lý lỗi validation nếu có
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu nhập không hợp lệ',
                'errors' => $e->errors() // Lấy thông báo lỗi từ ngoại lệ
            ], 422);
        } catch (\Exception $e) {
            // Xử lý lỗi nếu có (ví dụ: lỗi không tìm thấy bản ghi, lỗi cơ sở dữ liệu)
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi trong quá trình cập nhật',
                'error' => $e->getMessage()
            ], 500); // HTTP Status 500: Internal Server Error
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public
    function destroy(string $id)
    {
        try {
            $post = Post::findOrFail($id);
            $post->delete();
            return response()->json([
                'success' => true,
                'message' => 'Bài viết đã được xóa thành công!'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi trong quá trình xóa bài viết.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

interface Response {
    result: object
}

interface ThreadsListResponse extends Response {
    result: Thread[]
}

interface ThreadResponse extends Response {
    result: Thread
}

interface PostsListResponse extends Response {
    result: Post[]
}

interface PostResponse extends Response {
    result: Thread
}

interface Thread {
    id: number,
    title: string,
    slug: string,
    posts: Post[]
}

interface Post {
    id: number,
    title: string,
    content: string,
    created_at: string
}
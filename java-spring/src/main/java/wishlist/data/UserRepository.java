package wishlist.data;

import org.springframework.data.repository.CrudRepository;
import wishlist.User;

public interface UserRepository extends CrudRepository<User, Integer> {

    User findByUsername(String username);
}

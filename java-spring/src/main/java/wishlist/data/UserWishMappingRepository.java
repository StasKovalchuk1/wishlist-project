package wishlist.data;

import org.springframework.data.repository.CrudRepository;
import wishlist.User;
import wishlist.UserWishMapping;
import wishlist.UserWishMappingId;
import wishlist.Wish;

import java.util.List;


public interface UserWishMappingRepository extends CrudRepository<UserWishMapping, UserWishMappingId> {

    List<UserWishMapping> findAllByUser(User user);
}
